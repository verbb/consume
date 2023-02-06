<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Linode as LinodeProvider;

class Linode extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return LinodeProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'linode';

}