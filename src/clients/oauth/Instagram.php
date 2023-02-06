<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Facebook as InstagramProvider;

class Instagram extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return InstagramProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'instagram';


    // Public Methods
    // =========================================================================

    public function getOAuthProviderConfig(): array
    {
        $config = parent::getOAuthProviderConfig();
        $config['graphApiVersion'] = 'v15.0';

        return $config;
    }

}