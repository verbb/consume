<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Drip as DripProvider;

class Drip extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return DripProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'drip';

}