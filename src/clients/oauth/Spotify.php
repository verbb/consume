<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Spotify as SpotifyProvider;

class Spotify extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return SpotifyProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'spotify';

}