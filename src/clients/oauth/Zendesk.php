<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use Craft;
use craft\helpers\App;

use verbb\auth\Auth;
use verbb\auth\providers\Zendesk as ZendeskProvider;

use yii\base\InvalidConfigException;

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
        $subdomain = App::parseEnv($this->subdomain);

        if ($subdomain !== null && !$this->isValidHostnameLabel($subdomain)) {
            throw new InvalidConfigException(Craft::t('consume', 'Zendesk subdomain must resolve to a single valid hostname label.'));
        }

        return $subdomain;
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
        $rules[] = [['subdomain'], function(string $attribute): void {
            if (!$this->isValidHostnameLabel(App::parseEnv($this->$attribute))) {
                $this->addError($attribute, Craft::t('consume', 'Subdomain must resolve to a single valid hostname label.'));
            }
        }];

        return $rules;
    }

}
