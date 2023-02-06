<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Sugarcrm as SugarcrmProvider;

class Sugarcrm extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return SugarcrmProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'sugarcrm';

}