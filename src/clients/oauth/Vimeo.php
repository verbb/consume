<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Vimeo as VimeoProvider;

class Vimeo extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return VimeoProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'vimeo';

}