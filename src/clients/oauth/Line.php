<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Line as LineProvider;

class Line extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return LineProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'line';

}