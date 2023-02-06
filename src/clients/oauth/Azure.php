<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Azure as AzureProvider;

class Azure extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return AzureProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'azure';

}