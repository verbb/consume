<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use craft\helpers\App;

use verbb\auth\Auth;
use verbb\auth\providers\Vend as VendProvider;

class Vend extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return VendProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'vend';
    public ?string $storeName = null;


    // Public Methods
    // =========================================================================

    public function getStoreName(): ?string
    {
        return App::parseEnv($this->storeName);
    }

    public function getOAuthProviderConfig(): array
    {
        $config = parent::getOAuthProviderConfig();
        $config['storeName'] = $this->getStoreName();

        return $config;
    }


    // Protected Methods
    // =========================================================================

    protected function defineRules(): array
    {
        $rules = parent::defineRules();
        $rules[] = [['storeName'], 'required'];

        return $rules;
    }

}