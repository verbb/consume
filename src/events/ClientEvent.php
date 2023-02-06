<?php
namespace verbb\consume\events;

use verbb\consume\base\ClientInterface;

use yii\base\Event;

class ClientEvent extends Event
{
    // Properties
    // =========================================================================

    public ClientInterface $client;
    public bool $isNew = false;

}
