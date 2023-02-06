<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Harvest as HarvestProvider;

class Harvest extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return HarvestProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'harvest';

}