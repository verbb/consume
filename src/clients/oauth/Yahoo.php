<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Yahoo as YahooProvider;

class Yahoo extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return YahooProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'yahoo';

}