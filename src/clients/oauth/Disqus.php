<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Disqus as DisqusProvider;

class Disqus extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return DisqusProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'disqus';

}