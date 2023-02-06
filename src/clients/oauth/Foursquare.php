<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Foursquare as FoursquareProvider;

class Foursquare extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return FoursquareProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'foursquare';

}