<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Mollie as MollieProvider;

class Mollie extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return MollieProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'mollie';

}