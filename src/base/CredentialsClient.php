<?php
namespace verbb\consume\base;

use Craft;
use craft\helpers\StringHelper;

use verbb\auth\base\CredentialsProviderInterface;
use verbb\auth\base\CredentialsProviderTrait;

abstract class CredentialsClient extends Client implements CredentialsProviderInterface
{
    // Static Methods
    // =========================================================================

    public static function supportsConnection(): bool
    {
        return false;
    }


    // Properties
    // =========================================================================

    public static string $type = 'credentials';
    public static string $typeLabel = 'Credentials';


    // Traits
    // =========================================================================

    use CredentialsProviderTrait;


    // Public Methods
    // =========================================================================

    public function getSettingsHtml(): ?string
    {
        $handle = StringHelper::toKebabCase(static::$providerHandle);

        return Craft::$app->getView()->renderTemplate("consume/clients/credentials/_types/$handle", [
            'client' => $this,
        ]);
    }

    public function isConfigured(): bool
    {
        return false;
    }
}