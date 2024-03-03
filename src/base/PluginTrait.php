<?php
namespace verbb\consume\base;

use verbb\consume\Consume;
use verbb\consume\services\Clients;
use verbb\consume\services\Service;

use verbb\base\LogTrait;
use verbb\base\helpers\Plugin;

use verbb\auth\Auth;

trait PluginTrait
{
    // Properties
    // =========================================================================

    public static ?Consume $plugin = null;


    // Traits
    // =========================================================================

    use LogTrait;
    

    // Static Methods
    // =========================================================================

    public static function config(): array
    {
        Plugin::bootstrapPlugin('consume');

        return [
            'components' => [
                'clients' => Clients::class,
                'service' => Service::class,
            ],
        ];
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

}