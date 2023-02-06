<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Imgur as ImgurProvider;

class Imgur extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return ImgurProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'imgur';

}