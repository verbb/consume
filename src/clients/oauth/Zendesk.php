<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use craft\helpers\App;

use verbb\auth\Auth;
use verbb\auth\providers\Zendesk as ZendeskProvider;

class Zendesk extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return ZendeskProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'zendesk';
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
        $config['subdomain'] = $this->getSubdomain();

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