<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Mastodon as MastodonProvider;

class Mastodon extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return MastodonProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'mastodon';

}