<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\ConstantContact as ConstantContactProvider;

class ConstantContact extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return ConstantContactProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'constantContact';

}