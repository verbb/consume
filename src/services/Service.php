<?php
namespace verbb\consume\services;

use verbb\consume\Consume;
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
use Throwable;

use verbb\auth\helpers\UrlHelper as AuthUrlHelper;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class Service extends Component
{
    // Public Methods
    // =========================================================================

    public function fetchData(array|string $clientOpts, string $method = 'GET', string $uri = '', array $options = []): mixed
    {
        $settings = Consume::$plugin->getSettings();

        // Allow overriding cache/duration in templates
        $enableCache = ArrayHelper::remove($clientOpts, 'enableCache', $settings->enableCache);
        $cacheDuration = ArrayHelper::remove($clientOpts, 'cacheDuration', $settings->cacheDuration);

        // Only cache if we've requested it, and probably just for GET requests. Seems odd to cache POST/DELETE/PUT.
        if ($enableCache && $method === 'GET') {
            $seconds = ConfigHelper::durationInSeconds($cacheDuration);

            // Generate a cache key based on all the provided data and duration (in case we change it)
            $cacheKey = md5(Json::encode([$clientOpts, $method, $uri, $options, $seconds]));

            $cacheData = Craft::$app->getCache()->getOrSet($cacheKey, function() use ($clientOpts, $method, $uri, $options) {
                // Only set cache data if we have a result
                if ($cacheData = $this->fetchRawData($clientOpts, $method, $uri, $options)) {
                    return $cacheData;
                }

                // Returning `false` ensures that the result is not cached, and evaluated next time
                return false;
            }, $seconds);

            // Only return if we have a result
            if ($cacheData) {
                return $cacheData;
            }
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

            if ($handle) {
                if ($client = Consume::$plugin->getClients()->getClientByHandle($handle)) {
                    // Configure the client with any additional options passed in
                    $client->setProviderOptions($clientOpts);

                    // Make an authenticated request, either OAuth-based, or Guzzle
                    $response = $client->request($method, $uri, $options);

                    return $this->_parseResponse($format, $response);
                }
            }

            // Otherwise, we're probably passing in Guzzle settings for an in-template call
            // Normalise the Base URI and URI
            $uri = ltrim($uri, '/');
            $clientOpts['base_uri'] = AuthUrlHelper::normalizeBaseUri(($clientOpts['base_uri'] ?? ''));

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

        return $body;
    }

}
