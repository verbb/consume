<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Paypal as PaypalProvider;

class PayPal extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return PaypalProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'payPal';

}