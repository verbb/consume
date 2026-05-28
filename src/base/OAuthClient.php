<?php
namespace verbb\consume\base;

use verbb\consume\Consume;

use Craft;
use craft\helpers\StringHelper;

use verbb\auth\Auth;
use verbb\auth\base\OAuthProviderInterface;
use verbb\auth\base\OAuthProviderTrait;
use verbb\auth\helpers\RedirectUri;
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
        $this->normalizeScopes();

        $handle = StringHelper::toKebabCase(static::$providerHandle);
        $variables = $this->getSettingsHtmlVariables();

        return Craft::$app->getView()->renderTemplate("consume/clients/oauth/_types/$handle", $variables);
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
        return RedirectUri::getCallbackUri(Consume::$plugin->getSettings()->redirectUri, 'consume/auth/callback');
    }

    public function getAuthorizationUrlOptions(): array
    {
        $this->normalizeScopes();

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
            return Auth::getInstance()->getTokens()->getTokenByOwnerReference('consume', $this->id);
        }

        return null;
    }

    public function beforeSave(bool $isNew): bool
    {
        $this->normalizeScopes();

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

    protected function normalizeScopes(): void
    {
        $scopes = [];

        foreach ($this->scopes as $scope) {
            if (is_array($scope)) {
                $scope = $scope['scope'] ?? null;
            }

            if ($scope !== null && $scope !== '') {
                $scopes[] = (string)$scope;
            }
        }

        $this->scopes = $scopes;
    }
}