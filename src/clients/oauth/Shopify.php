<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Shopify as ShopifyProvider;

class Shopify extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return ShopifyProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'shopify';

}