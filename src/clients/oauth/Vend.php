<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use Craft;
use craft\helpers\App;

use verbb\auth\Auth;
use verbb\auth\providers\Vend as VendProvider;

use yii\base\InvalidConfigException;

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
        $storeName = App::parseEnv($this->storeName);

        if ($storeName !== null && !$this->isValidHostnameLabel($storeName)) {
            throw new InvalidConfigException(Craft::t('consume', 'Vend store name must resolve to a single valid hostname label.'));
        }

        return $storeName;
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
        $rules[] = [['storeName'], function(string $attribute): void {
            if (!$this->isValidHostnameLabel(App::parseEnv($this->$attribute))) {
                $this->addError($attribute, Craft::t('consume', 'Store Name must resolve to a single valid hostname label.'));
            }
        }];

        return $rules;
    }

}
