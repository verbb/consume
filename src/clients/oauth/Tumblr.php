<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Tumblr as TumblrProvider;

class Tumblr extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return TumblrProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'tumblr';

}