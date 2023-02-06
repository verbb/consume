<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Square as SquareProvider;

class Square extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return SquareProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'square';

}