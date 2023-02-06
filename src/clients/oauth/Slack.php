<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Slack as SlackProvider;

class Slack extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return SlackProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'slack';

}