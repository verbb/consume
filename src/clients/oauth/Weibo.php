<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Weibo as WeiboProvider;

class Weibo extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return WeiboProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'weibo';

}