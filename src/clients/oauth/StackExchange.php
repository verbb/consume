<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\StackExchange as StackExchangeProvider;

class StackExchange extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return StackExchangeProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'stackExchange';

}