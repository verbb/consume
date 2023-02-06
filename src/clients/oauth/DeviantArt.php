<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\DeviantArt as DeviantArtProvider;

class DeviantArt extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return DeviantArtProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'deviantArt';

}