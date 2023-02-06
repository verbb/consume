<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Microsoft as MicrosoftProvider;

class Microsoft extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return MicrosoftProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'microsoft';

}