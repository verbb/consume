<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Twitch as TwitchProvider;

class Twitch extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return TwitchProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'twitch';

}