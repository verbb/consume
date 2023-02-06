<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\HubSpot as HubSpotProvider;

class HubSpot extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return HubSpotProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'hubSpot';

}