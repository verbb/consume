<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Bitbucket as BitbucketProvider;

class Bitbucket extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return BitbucketProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'bitbucket';

}