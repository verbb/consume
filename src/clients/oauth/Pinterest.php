<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Pinterest as PinterestProvider;

class Pinterest extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return PinterestProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'pinterest';

}