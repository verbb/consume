<?php
namespace verbb\consume\clients;

use verbb\consume\base\Client;

use Craft;
use craft\base\MissingComponentInterface;
use craft\base\MissingComponentTrait;

use yii\base\NotSupportedException;

class MissingClient extends Client implements MissingComponentInterface
{
    // Traits
    // =========================================================================

    use MissingComponentTrait;


    // Static Methods
    // =========================================================================

    public static function displayName(): string
    {
        return Craft::t('consume', 'Missing Client');
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'missingClient';
}
