<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\TikTok as TikTokProvider;

class TikTok extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return TikTokProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'tikTok';

}