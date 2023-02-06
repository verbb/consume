<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Unsplash as UnsplashProvider;

class Unsplash extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return UnsplashProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'unsplash';

}