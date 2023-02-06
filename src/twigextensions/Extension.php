<?php
namespace verbb\consume\twigextensions;

use verbb\consume\Consume;

use Craft;

use Twig\Extension\AbstractExtension;
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

    public function fetchData(array|string $client, string $method = 'GET', string $uri = '', array $options = []): mixed
    {
        return Consume::$plugin->getService()->fetchData($client, $method, $uri, $options);
    }
}
