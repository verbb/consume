<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Marketo as MarketoProvider;

class Marketo extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return MarketoProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'marketo';

}