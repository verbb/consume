<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Fedex as FedexProvider;

class Fedex extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return FedexProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'fedex';

}