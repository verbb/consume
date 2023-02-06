<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Envato as EnvatoProvider;

class Envato extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return EnvatoProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'envato';

}