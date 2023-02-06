<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Trustpilot as TrustpilotProvider;

class Trustpilot extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return TrustpilotProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'trustpilot';

}