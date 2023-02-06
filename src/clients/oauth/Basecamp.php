<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Basecamp as BasecampProvider;

class Basecamp extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return BasecampProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'basecamp';

}