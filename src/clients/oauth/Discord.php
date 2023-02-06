<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Discord as DiscordProvider;

class Discord extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return DiscordProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'discord';

}