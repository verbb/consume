<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use craft\helpers\App;

use verbb\auth\Auth;
use verbb\auth\providers\Zoho as ZohoProvider;

class Zoho extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return ZohoProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'zoho';
    public ?string $dataCenter = 'US';


    // Public Methods
    // =========================================================================

    public function getDataCenter(): ?string
    {
        return App::parseEnv($this->dataCenter);
    }

    public function defineRules(): array
    {
        $rules = parent::defineRules();
        $rules[] = [['dataCenter'], 'required'];

        return $rules;
    }

    public function getOAuthProviderConfig(): array
    {
        $config = parent::getOAuthProviderConfig();
        $config['dc'] = $this->getDataCenter();

        return $config;
    }

    public function getAuthorizationUrlOptions(): array
    {
        $options = parent::getAuthorizationUrlOptions();
        $options['access_type'] = 'offline';
        $options['prompt'] = 'consent';
        
        return $options;
    }
}