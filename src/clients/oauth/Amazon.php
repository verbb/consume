<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Amazon as AmazonProvider;

class Amazon extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return AmazonProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'amazon';

}