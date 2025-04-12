<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\GitHub as GitHubProvider;

class GitHub extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return GitHubProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'gitHub';

}