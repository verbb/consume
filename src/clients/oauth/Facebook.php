<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Facebook as FacebookProvider;

class Facebook extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return FacebookProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'facebook';


    // Public Methods
    // =========================================================================

    public function getOAuthProviderConfig(): array
    {
        $config = parent::getOAuthProviderConfig();
        $config['graphApiVersion'] = 'v15.0';

        return $config;
    }

}