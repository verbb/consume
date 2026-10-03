<?php
namespace verbb\consume\base;

use verbb\consume\Consume;
use verbb\consume\helpers\ResponseLimiter;

use Craft;
use craft\helpers\StringHelper;

use verbb\auth\base\CredentialsProviderInterface;
use verbb\auth\base\CredentialsProviderTrait;

use GuzzleHttp\Client as GuzzleClient;

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

    use CredentialsProviderTrait {
        getCredentialsProvider as private _getCredentialsProvider;
    }


    // Public Methods
    // =========================================================================

    public function getCredentialsProvider(): GuzzleClient
    {
        return ResponseLimiter::withClient(
            $this->_getCredentialsProvider(),
            Consume::$plugin->getSettings()->maxResponseBytes,
        );
    }

    public function getSettingsHtml(): ?string
    {
        $handle = StringHelper::toKebabCase(static::$providerHandle);
        $variables = $this->getSettingsHtmlVariables();

        return Craft::$app->getView()->renderTemplate("consume/clients/credentials/_types/$handle", $variables);
    }

    public function isConfigured(): bool
    {
        return false;
    }
}
