<?php
namespace verbb\consume\events;

use craft\events\CancelableEvent;

class FetchEvent extends CancelableEvent
{
    // Properties
    // =========================================================================

    public array|string $clientOpts;
    public string $method;
    public string $uri;
    public array $options;

    public mixed $response = null;

}
