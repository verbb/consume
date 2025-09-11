<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use craft\helpers\App;

use verbb\auth\providers\Generic as GenericProvider;

class Generic extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return GenericProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'generic';
    public ?string $url = null;
    public ?string $authorizationUrl = null;
    public ?string $tokenUrl = null;
    public ?string $username = null;
    public ?string $password = null;
    public ?string $grant = 'authorization_code';


    // Public Methods
    // =========================================================================

    public function getUrl(): ?string
    {
        return App::parseEnv($this->url);
    }

    public function getAuthorizationUrl(): ?string
    {
        return App::parseEnv($this->authorizationUrl);
    }

    public function getTokenUrl(): ?string
    {
        return App::parseEnv($this->tokenUrl);
    }

    public function getGrant(): string
    {
        return $this->grant;
    }

    public function getOAuthProviderConfig(): array
    {
        $config = parent::getOAuthProviderConfig();
        $config['urlAuthorize'] = $this->getAuthorizationUrl();
        $config['urlAccessToken'] = $this->getTokenUrl();
        $config['urlResourceOwnerDetails'] = $this->getUrl();
        $config['scopes'] = $this->scopes;
        $config['scopeSeparator'] = $this->scopeSeparator;
        $config['baseApiUrl'] = $this->getUrl();

        // Merge in any additional config options set at the template level
        $config = array_merge($config, $this->getProviderOptions());

        return $config;
    }


    // Protected Methods
    // =========================================================================

    protected function defineRules(): array
    {
        $rules = parent::defineRules();

        $rules[] = [
            ['url'], 'required', 'when' => function($model) {
                return $model->enabled;
            },
        ];

        return $rules;
    }

}