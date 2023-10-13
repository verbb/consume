<?php
namespace verbb\consume\base;

use Craft;
use craft\helpers\ArrayHelper;
use craft\helpers\StringHelper;
use craft\helpers\UrlHelper;

use verbb\auth\Auth;
use verbb\auth\base\OAuthProviderInterface;
use verbb\auth\base\OAuthProviderTrait;
use verbb\auth\models\Token;

abstract class OAuthClient extends Client implements OAuthProviderInterface
{
    // Static Methods
    // =========================================================================

    public static function supportsConnection(): bool
    {
        return true;
    }


    // Properties
    // =========================================================================

    public static string $type = 'oauth';
    public static string $typeLabel = 'OAuth';
    public array $scopes = [];
    public string $scopeSeparator = ' ';


    // Traits
    // =========================================================================

    use OAuthProviderTrait;
    

    // Public Methods
    // =========================================================================

    public function settingsAttributes(): array
    {
        // These won't be picked up in a Trait
        $attributes = parent::settingsAttributes();
        $attributes[] = 'clientId';
        $attributes[] = 'clientSecret';
        $attributes[] = 'scopes';

        return $attributes;
    }

    public function getSettingsHtml(): ?string
    {
        $handle = StringHelper::toKebabCase(static::$providerHandle);

        return Craft::$app->getView()->renderTemplate("consume/clients/oauth/_types/$handle", [
            'client' => $this,
        ]);
    }

    public function isConfigured(): bool
    {
        return $this->clientId && $this->clientSecret;
    }

    public function isConnected(): bool
    {
        return (bool)$this->getToken();
    }

    public function getRedirectUri(): ?string
    {
        $siteId = Craft::$app->getSites()->getPrimarySite()->id;

        // We should always use the primary site for the redirect
        return UrlHelper::siteUrl('consume/auth/callback', null, null, $siteId);
    }

    public function getAuthorizationUrlOptions(): array
    {
        // Create custom scopes with the provided scope separator, and still pass in as an array so that
        // they're merged with the default provider scopes as well.
        $scopes = implode($this->scopeSeparator, $this->scopes);

        return [
            'scope' => [$scopes],
        ];
    }

    public function getToken(): ?Token
    {
        if ($this->id) {
            return Auth::$plugin->getTokens()->getTokenByOwnerReference('consume', $this->id);
        }

        return null;
    }

    public function beforeSave(bool $isNew): bool
    {
        // Normalise editable table values
        if (isset($this->scopes[0])) {
            $this->scopes = ArrayHelper::getColumn($this->scopes, 'scope');
        }

        return parent::beforeSave($isNew);
    }


    // Protected Methods
    // =========================================================================

    protected function defineRules(): array
    {
        $rules = parent::defineRules();

        $rules[] = [
            ['clientId', 'clientSecret'], 'required', 'when' => function($model) {
                return $model->enabled;
            },
        ];

        return $rules;
    }
}