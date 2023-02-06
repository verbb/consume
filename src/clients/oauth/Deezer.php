<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Deezer as DeezerProvider;

class Deezer extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return DeezerProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'deezer';

}