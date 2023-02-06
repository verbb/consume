<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Twitter as TwitterProvider;

class Twitter extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return TwitterProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'twitter';

}