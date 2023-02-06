<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Buddy as BuddyProvider;

class Buddy extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return BuddyProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'buddy';

}