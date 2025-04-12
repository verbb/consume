<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use craft\helpers\App;

use verbb\auth\Auth;
use verbb\auth\providers\PayPal as PayPalProvider;

class PayPal extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return PayPalProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'payPal';
    public bool|string $useSandbox = false;


    // Public Methods
    // =========================================================================

    public function getUseSandbox(): string
    {
        return App::parseBooleanEnv($this->useSandbox);
    }

    public function getOAuthProviderConfig(): array
    {
        $config = parent::getOAuthProviderConfig();
        $config['isSandbox'] = $this->getUseSandbox();

        return $config;
    }

}