<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Heroku as HerokuProvider;

class Heroku extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return HerokuProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'heroku';

}