<?php
namespace verbb\consume\models;

use craft\base\Model;

class Settings extends Model
{
    // Properties
    // =========================================================================

    public string $pluginName = 'Consume';
    public bool $enableCache = true;
    public mixed $cacheDuration = 'PT1H';

}
