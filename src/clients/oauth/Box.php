<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Box as BoxProvider;

class Box extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return BoxProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'box';

}