<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Strava as StravaProvider;

class Strava extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return StravaProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'strava';

}