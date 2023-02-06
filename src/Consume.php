<?php
namespace verbb\consume;

use verbb\consume\base\PluginTrait;
use verbb\consume\models\Settings;
use verbb\consume\twigextensions\Extension;
use verbb\consume\variables\ConsumeVariable;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\UrlHelper;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;

use yii\base\Event;

class Consume extends Plugin
{
    // Properties
    // =========================================================================

    public bool $hasCpSection = true;
    public bool $hasCpSettings = true;
    public string $schemaVersion = '1.0.0';


    // Traits
    // =========================================================================

    use PluginTrait;


    // Public Methods
    // =========================================================================

    public function init(): void
    {
        parent::init();

        self::$plugin = $this;

        $this->_setPluginComponents();
        $this->_setLogging();
        $this->_registerTwigExtensions();
        $this->_registerVariables();

        if (Craft::$app->getRequest()->getIsCpRequest()) {
            $this->_registerCpRoutes();
        }

        if (Craft::$app->getRequest()->getIsSiteRequest()) {
            $this->_registerSiteRoutes();
        }
    }

    public function getPluginName(): string
    {
        return Craft::t('consume', $this->getSettings()->pluginName);
    }

    public function getSettingsResponse(): mixed
    {
        return Craft::$app->getResponse()->redirect(UrlHelper::cpUrl('consume/settings'));
    }


    // Protected Methods
    // =========================================================================

    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }


    // Private Methods
    // =========================================================================

    private function _registerTwigExtensions(): void
    {
        Craft::$app->view->registerTwigExtension(new Extension);
    }

    private function _registerCpRoutes(): void
    {
        Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_CP_URL_RULES, function(RegisterUrlRulesEvent $event) {
            $event->rules['consume'] = 'consume/clients/index';
            $event->rules['consume/clients'] = 'consume/clients/index';
            $event->rules['consume/clients/credentials/new'] = 'consume/clients/edit-credentials';
            $event->rules['consume/clients/credentials/<handle:{handle}>'] = 'consume/clients/edit-credentials';
            $event->rules['consume/clients/oauth/new'] = 'consume/clients/edit-oauth';
            $event->rules['consume/clients/oauth/<handle:{handle}>'] = 'consume/clients/edit-oauth';
            $event->rules['consume/settings'] = 'consume/plugin/settings';
        });
    }

    private function _registerSiteRoutes(): void
    {
        Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_SITE_URL_RULES, function(RegisterUrlRulesEvent $event) {
            $event->rules['consume/auth/callback'] = 'consume/auth/callback';
        });
    }

    private function _registerVariables(): void
    {
        Event::on(CraftVariable::class, CraftVariable::EVENT_INIT, function(Event $event) {
            $event->sender->set('consume', ConsumeVariable::class);
        });
    }
}
