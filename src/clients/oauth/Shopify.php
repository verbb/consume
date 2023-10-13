<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use craft\helpers\App;

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
    public ?string $subdomain = null;


    // Public Methods
    // =========================================================================

    public function getSubdomain(): ?string
    {
        return App::parseEnv($this->subdomain);
    }

    public function getOAuthProviderConfig(): array
    {
        $config = parent::getOAuthProviderConfig();
        $config['shop'] = $this->getSubdomain();

        return $config;
    }


    // Protected Methods
    // =========================================================================

    protected function defineRules(): array
    {
        $rules = parent::defineRules();
        $rules[] = [['subdomain'], 'required'];

        return $rules;
    }

}