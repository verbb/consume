<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Github as GithubProvider;

class GitHub extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return GithubProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'gitHub';

}