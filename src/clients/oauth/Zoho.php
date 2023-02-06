<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Zoho as ZohoProvider;

class Zoho extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return ZohoProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'zoho';

}