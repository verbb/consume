<?php
namespace verbb\consume\base;

use verbb\consume\Consume;
use verbb\consume\services\Clients;
use verbb\consume\services\Service;

use Craft;

use yii\log\Logger;

use verbb\auth\Auth;
use verbb\base\BaseHelper;

trait PluginTrait
{
    // Static Properties
    // =========================================================================

    public static Consume $plugin;


    // Public Methods
    // =========================================================================

    public static function log($message, $attributes = []): void
    {
        if ($attributes) {
            $message = Craft::t('consume', $message, $attributes);
        }

        Craft::getLogger()->log($message, Logger::LEVEL_INFO, 'consume');
    }

    public static function error($message, $attributes = []): void
    {
        if ($attributes) {
            $message = Craft::t('consume', $message, $attributes);
        }

        Craft::getLogger()->log($message, Logger::LEVEL_ERROR, 'consume');
    }


    // Public Methods
    // =========================================================================

    public function getClients(): Clients
    {
        return $this->get('clients');
    }

    public function getService(): Service
    {
        return $this->get('service');
    }


    // Private Methods
    // =========================================================================

    private function _setPluginComponents(): void
    {
        $this->setComponents([
            'clients' => Clients::class,
            'service' => Service::class,
        ]);

        Auth::registerModule();
        BaseHelper::registerModule();
    }

    private function _setLogging(): void
    {
        BaseHelper::setFileLogging('consume');
    }

}