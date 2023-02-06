<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\SoundCloud as SoundCloudProvider;

class SoundCloud extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return SoundCloudProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'soundCloud';

}