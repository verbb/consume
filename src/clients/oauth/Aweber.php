<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Aweber as AweberProvider;

class Aweber extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return AweberProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'aweber';

}