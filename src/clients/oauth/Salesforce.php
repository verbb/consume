<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Salesforce as SalesforceProvider;

class Salesforce extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return SalesforceProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'salesforce';

}