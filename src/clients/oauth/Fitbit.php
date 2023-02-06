<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Fitbit as FitbitProvider;

class Fitbit extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return FitbitProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'fitbit';

}