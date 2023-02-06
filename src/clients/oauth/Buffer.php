<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Buffer as BufferProvider;

class Buffer extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return BufferProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'buffer';

}