<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Odnoklassniki as OdnoklassnikiProvider;

class Odnoklassniki extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return OdnoklassnikiProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'odnoklassniki';

}