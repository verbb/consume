<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\FreshBooks as FreshBooksProvider;

class FreshBooks extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return FreshBooksProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'freshBooks';

}