<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Dropbox as DropboxProvider;

class Dropbox extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return DropboxProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'dropbox';

}