<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Stripe as StripeProvider;

class Stripe extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return StripeProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'stripe';

}