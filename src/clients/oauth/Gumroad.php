<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Gumroad as GumroadProvider;

class Gumroad extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return GumroadProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'gumroad';

}