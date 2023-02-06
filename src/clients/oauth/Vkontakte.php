<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Vkontakte as VkontakteProvider;

class Vkontakte extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return VkontakteProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'vkontakte';

}