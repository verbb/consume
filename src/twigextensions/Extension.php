<?php
namespace verbb\consume\twigextensions;

use verbb\consume\Consume;

use Craft;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Extension extends AbstractExtension
{
    // Public Methods
    // =========================================================================

    public function getName(): string
    {
        return 'Consume';
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('consume', [$this, 'fetchData']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('hash_str', [$this, 'hash_str']),
            new TwigFilter('hash_hmac', [$this, 'hash_hmac']),
        ];
    }

    public function fetchData(array|string $client, string $method = 'GET', string $uri = '', array $options = []): mixed
    {
        return Consume::$plugin->getService()->fetchData($client, $method, $uri, $options);
    }

    public function hash_str(string $data, string $algo, bool $binary = false): string
    {
        return hash($algo, $data, $binary);
    }

    public function hash_hmac(string $data, string $algo, string $key, bool $binary = false): string
    {
        return hash_hmac($algo, $data, $key, $binary);
    }
}
