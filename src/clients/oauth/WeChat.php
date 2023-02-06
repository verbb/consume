<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\WeChat as WeChatProvider;

class WeChat extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return WeChatProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'weChat';

}