<?php
namespace verbb\consume\helpers;

use verbb\consume\exceptions\ResponseTooLargeException;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\LazyOpenStream;
use GuzzleHttp\Psr7\Utils;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Throwable;

class ResponseLimiter
{
    // Constants
    // =========================================================================

    public const DEFAULT_MAX_BYTES = 10_485_760;

    private const MIDDLEWARE_NAME = 'consume-response-limit';


    // Static Methods
    // =========================================================================

    public static function withClient(Client $client, int $maximumBytes): Client
    {
        self::_validateMaximumBytes($maximumBytes);

        $config = $client->getConfig();
        $handler = $config['handler'] ?? null;

        if ($handler instanceof HandlerStack) {
            $handler = clone $handler;
        } elseif ($handler !== null) {
            $handler = new HandlerStack($handler);
        } else {
            $handler = HandlerStack::create();
        }

        // Replacing an existing boundary keeps repeated OAuth provider setup idempotent and
        // ensures a changed setting takes effect on the provider's retained HTTP client.
        $handler->remove(self::MIDDLEWARE_NAME);
        $handler->push(self::_responseLimitMiddleware($maximumBytes), self::MIDDLEWARE_NAME);
        $config['handler'] = $handler;

        return new Client($config);
    }

    public static function limitResponse(ResponseInterface $response, int $maximumBytes): ResponseInterface
    {
        self::_validateMaximumBytes($maximumBytes);
        self::_assertResponseSize($response, $maximumBytes);

        if (!$response->getBody() instanceof LimitedResponseStream || !$response->getBody()->enforcesMaximumBytes($maximumBytes)) {
            $response = $response->withBody(new LimitedResponseStream($response->getBody(), $maximumBytes));
        }

        return $response;
    }

    public static function isResponseTooLarge(Throwable $exception): bool
    {
        do {
            if ($exception instanceof ResponseTooLargeException) {
                return true;
            }
        } while ($exception = $exception->getPrevious());

        return false;
    }

    private static function _responseLimitMiddleware(int $maximumBytes): callable
    {
        return static function(callable $handler) use ($maximumBytes): callable {
            return static function(RequestInterface $request, array $options) use ($handler, $maximumBytes): PromiseInterface {
                self::_assertCompatibleOptions($options);

                $onHeaders = $options['on_headers'] ?? null;
                $options['on_headers'] = static function(ResponseInterface $response) use ($maximumBytes, $onHeaders): void {
                    self::_assertResponseSize($response, $maximumBytes);

                    if ($onHeaders !== null) {
                        $onHeaders($response);
                    }
                };

                // Streaming can return an unread network body before its size is known. A bounded sink
                // instead rejects chunked, decompressed and incorrectly declared bodies during transfer.
                $options['stream'] = false;
                $options['sink'] = new LimitedResponseStream(self::_responseSink($options['sink'] ?? null), $maximumBytes, false);

                return $handler($request, $options)->then(static function(ResponseInterface $response) use ($maximumBytes): ResponseInterface {
                    return self::limitResponse($response, $maximumBytes);
                });
            };
        };
    }

    private static function _responseSink(mixed $sink): StreamInterface
    {
        if ($sink === null) {
            $sink = Utils::tryFopen('php://temp', 'w+');
        }

        if (is_string($sink)) {
            return new LazyOpenStream($sink, 'w+');
        }

        return Utils::streamFor($sink);
    }

    private static function _assertCompatibleOptions(array $options): void
    {
        if (!isset($options['curl']) || !is_array($options['curl'])) {
            return;
        }

        foreach (['CURLOPT_WRITEFUNCTION', 'CURLOPT_FILE', 'CURLOPT_RETURNTRANSFER'] as $constant) {
            if (defined($constant) && array_key_exists(constant($constant), $options['curl'])) {
                throw new InvalidArgumentException('Low-level cURL response output options cannot be used with Consume response limits. Use the sink request option instead.');
            }
        }
    }

    private static function _assertResponseSize(ResponseInterface $response, int $maximumBytes): void
    {
        foreach ($response->getHeader('Content-Length') as $headerValue) {
            foreach (explode(',', $headerValue) as $length) {
                $length = trim($length);

                if ($length !== '' && ctype_digit($length) && (int)$length > $maximumBytes) {
                    throw new ResponseTooLargeException(sprintf('Response exceeded the %d-byte limit.', $maximumBytes));
                }
            }
        }

        $bodySize = $response->getBody()->getSize();

        if ($bodySize !== null && $bodySize > $maximumBytes) {
            throw new ResponseTooLargeException(sprintf('Response exceeded the %d-byte limit.', $maximumBytes));
        }
    }

    private static function _validateMaximumBytes(int $maximumBytes): void
    {
        if ($maximumBytes < 1) {
            throw new InvalidArgumentException('The maximum response size must be at least one byte.');
        }
    }
}
