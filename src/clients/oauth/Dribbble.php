<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Dribbble as DribbbleProvider;

class Dribbble extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return DribbbleProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'dribbble';

}