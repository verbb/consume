<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Uber as UberProvider;

class Uber extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return UberProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'uber';

}