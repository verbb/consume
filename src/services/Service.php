<?php
namespace verbb\consume\services;

use verbb\consume\Consume;
use verbb\consume\base\OAuthClient;
use verbb\consume\events\FetchEvent;
use verbb\consume\models\Settings;

use Craft;
use craft\base\Component;
use craft\helpers\ArrayHelper;
use craft\helpers\DateTimeHelper;
use craft\helpers\ConfigHelper;
use craft\helpers\Json;
use craft\helpers\UrlHelper;

use DateTime;
use DateTimeZone;
use Exception;
use Throwable;

use yii\base\Event;
use yii\caching\TagDependency;

use GuzzleHttp\Exception\RequestException;

use verbb\auth\helpers\UrlHelper as AuthUrlHelper;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class Service extends Component
{
    // Constants
    // =========================================================================

    public const EVENT_BEFORE_FETCH_DATA = 'beforeFetchData';


    // Public Methods
    // =========================================================================

    public function fetchData(array|string $clientOpts, string $method = 'GET', string $uri = '', array $options = []): mixed
    {
        $event = new FetchEvent([
            'clientOpts' => $clientOpts,
            'method' => $method,
            'uri' => $uri,
            'options' => $options,
        ]);

        Event::trigger(self::class, self::EVENT_BEFORE_FETCH_DATA, $event);

        if (!$event->isValid) {
            return $event->response;
        }

        $settings = Consume::$plugin->getSettings();

        // `cacheDuration` / per-request `enableCache` live on the client opts (not Guzzle $options).
        $cacheDuration = ArrayHelper::remove($clientOpts, 'cacheDuration', $settings->cacheDuration);

        // Per-request: whether to read from cache first. Default matches plugin `enableCache` when omitted.
        $readFromCache = ArrayHelper::remove($clientOpts, 'enableCache', $settings->enableCache);

        // Plugin `enableCache` is the master switch: no cache reads or writes when disabled.
        $pluginCacheEnabled = $settings->enableCache;

        if (!$pluginCacheEnabled) {
            $readFromCache = false;
        }

        // Only interact with Craft cache for GET; POST/PUT/DELETE are never cached here.
        if ($method !== 'GET' || !$pluginCacheEnabled) {
            return $this->fetchRawData($clientOpts, $method, $uri, $options);
        }

        $seconds = ConfigHelper::durationInSeconds($cacheDuration);
        $cacheTags = ['consume'];

        if (is_string($clientOpts)) {
            $cacheTags[] = 'consume:' . $clientOpts;
        }

        $cacheKey = md5(Json::encode([$clientOpts, $method, $uri, $options, $seconds]));

        $dependency = new TagDependency([
            'tags' => $cacheTags,
        ]);

        if ($readFromCache) {
            $cacheData = Craft::$app->getCache()->getOrSet($cacheKey, function() use ($clientOpts, $method, $uri, $options) {
                if ($cacheData = $this->fetchRawData($clientOpts, $method, $uri, $options)) {
                    return $cacheData;
                }

                // Returning `false` ensures that the result is not cached, and evaluated next time
                return false;
            }, $seconds, $dependency);

            if ($cacheData) {
                return $cacheData;
            }
        } else {
            // Skip cache read (fresh fetch), but still warm the cache for other requests when the plugin has caching on.
            $data = $this->fetchRawData($clientOpts, $method, $uri, $options);
            
            if ($data) {
                Craft::$app->getCache()->set($cacheKey, $data, $seconds, $dependency);
            }

            return $data;
        }

        return $this->fetchRawData($clientOpts, $method, $uri, $options);
    }

    public function fetchRawData(array|string $clientOpts, string $method = '', string $uri = '', array $options = []): mixed
    {
        try {
            // Check if we're dealing with a predefined client, either the handle of the client, or an object
            // with the handle, including extra client-based settings like headers, URL, format, etc
            if (is_string($clientOpts)) {
                $clientOpts = ['handle' => $clientOpts];
            }

            // Detect what format we're needing to parse
            $format = ArrayHelper::remove($clientOpts, 'format', 'json');
            $handle = ArrayHelper::remove($clientOpts, 'handle');

            // See if we want to include any errors in the response, rather than return `null`
            $includeErrorResponse = ArrayHelper::remove($options, 'includeErrorResponse', false);

            // Otherwise, we're probably passing in Guzzle settings for an in-template call
            // Normalise the Base URI and URI
            $uri = ltrim($uri, '/');

            // Normalize the Base URI if we provide a URI. Sometimes, we may provide the "Base URI" as
            // the full URL for the request which can throw an error if we add a trailing slash.
            // `baseUri` = `https://api.dev/v12/api.php`
            // We might also provide a URI when needs a trialing slash to work properly with Guzzle, 
            // and according to their spec. This can be seen for some URLs like:
            // `baseUri` = `https://api.dev/v12.0`
            // `uri` = `test/endpoint`
            // where without the trailing slash, `v12.0` would be stripped. But would would want to include
            // the trailing slash if there was no URI, in case it's the full, absolute URL used as the Base URI.
            if ($uri) {
                if (isset($clientOpts['base_uri']) && !str_ends_with($clientOpts['base_uri'], '/')) {
                    $clientOpts['base_uri'] .= '/';
                }
            }
        
            if ($handle) {
                if ($client = Consume::$plugin->getClients()->getClientByHandle($handle)) {
                    // Configure the client with any additional options passed in
                    $client->setProviderOptions($clientOpts);

                    if ($client instanceof OAuthClient) {
                        // Provide a nicer error message when token is missing
                        if (!$client->getToken()) {
                            throw new Exception('Client token missing, please ensure the client is connected.');
                        }
                    }

                    // Make an authenticated request, either OAuth-based, or Guzzle
                    $response = $client->request($method, $uri, $options);

                    return $this->_parseResponse($format, $response);
                }
            }

            $client = Craft::createGuzzleClient($clientOpts);

            $response = $client->request($method, $uri, $options);

            return $this->_parseResponse($format, $response);
        } catch (Throwable $e) {
            Consume::error('Unable to fetch data: “{message}” {file}:{line}. Trace: “{trace}”.', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Check if we want to return any errors rather than just return `null`
            if ($e instanceof RequestException && $includeErrorResponse) {
                return ['error' => $this->_parseResponse($format, $e->getResponse())];
            }
        }

        return null;
    }


    // Private Methods
    // =========================================================================

    private function _parseResponse(string $format, mixed $response): mixed
    {
        // Check if already an array, just return that (for OAuth clients that have their own parsing logic)
        if (is_array($response)) {
            return $response;
        }

        $body = (string)$response->getBody()->getContents();

        if ($format === 'json') {
            return Json::decode($body);
        }

        if ($format === 'xml') {
            return (new XmlEncoder())->decode($body, 'xml');
        }

        if ($format === 'csv') {
            return (new CsvEncoder())->decode($body, 'csv');
        }

        if ($format === 'raw') {
            return $response;
        }

        return $body;
    }

}
