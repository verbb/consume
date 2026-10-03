<?php
namespace verbb\consume\models;

use verbb\consume\helpers\ResponseLimiter;

use craft\base\Model;

class Settings extends Model
{
    // Properties
    // =========================================================================

    public string $pluginName = 'Consume';
    public bool $enableCache = true;
    public mixed $cacheDuration = 'PT1H';
    public int $maxResponseBytes = ResponseLimiter::DEFAULT_MAX_BYTES;
    public ?string $redirectUri = null;


    // Protected Methods
    // =========================================================================

    protected function defineRules(): array
    {
        $rules = parent::defineRules();

        $rules[] = [['pluginName'], 'trim'];
        $rules[] = [['pluginName'], 'required'];
        $rules[] = [['maxResponseBytes'], 'integer', 'min' => 1];

        return $rules;
    }
}
