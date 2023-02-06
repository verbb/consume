<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Yelp as YelpProvider;

class Yelp extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return YelpProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'yelp';

}