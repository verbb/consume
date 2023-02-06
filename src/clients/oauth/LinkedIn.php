<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\LinkedIn as LinkedInProvider;

class LinkedIn extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return LinkedInProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'linkedIn';

}