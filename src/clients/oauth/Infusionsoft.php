<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Infusionsoft as InfusionsoftProvider;

class Infusionsoft extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return InfusionsoftProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'infusionsoft';

}