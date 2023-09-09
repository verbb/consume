<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use craft\helpers\App;

use verbb\auth\Auth;
use verbb\auth\providers\Azure as AzureProvider;

class Azure extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return AzureProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'azure';
    public ?string $tenant = 'common';


    // Public Methods
    // =========================================================================

    public function getTenant(): ?string
    {
        return App::parseEnv($this->tenant);
    }

    public function getOAuthProviderConfig(): array
    {
        $config = parent::getOAuthProviderConfig();
        $config['tenant'] = $this->getTenant();

        return $config;
    }

}