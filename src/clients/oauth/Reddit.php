<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Reddit as RedditProvider;

class Reddit extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return RedditProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'reddit';

}