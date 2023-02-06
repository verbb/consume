<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Etsy as EtsyProvider;

class Etsy extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return EtsyProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'etsy';

}