<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Snapchat as SnapchatProvider;

class Snapchat extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return SnapchatProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'snapchat';

}