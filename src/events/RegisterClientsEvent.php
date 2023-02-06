<?php
namespace verbb\consume\events;

use yii\base\Event;

class RegisterClientsEvent extends Event
{
    // Properties
    // =========================================================================

    public ?array $credentials = [];
    public ?array $oauth = [];
    
}
