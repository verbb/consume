<?php
namespace verbb\consume\variables;

use verbb\consume\Consume;
use verbb\consume\base\ClientInterface;

class ConsumeVariable
{
    // Public Methods
    // =========================================================================

    public function getPlugin(): Consume
    {
        return Consume::$plugin;
    }

    public function getPluginName(): string
    {
        return Consume::$plugin->getPluginName();
    }

    public function getAllClients(): array
    {
        return Consume::$plugin->getClients()->getAllClients();
    }

    public function getAllEnabledClients(): array
    {
        return Consume::$plugin->getClients()->getAllEnabledClients();
    }

    public function getAllConfiguredClients(): array
    {
        return Consume::$plugin->getClients()->getAllConfiguredClients();
    }

    public function getClientById(int $id): ?ClientInterface
    {
        return Consume::$plugin->getClients()->getClientById($id);
    }

    public function getClientByHandle(string $handle): ?ClientInterface
    {
        return Consume::$plugin->getClients()->getClientByHandle($handle);
    }

    public function fetchData(array|string $client, string $method = 'GET', string $uri = '', array $options = []): mixed
    {
        return Consume::$plugin->getService()->fetchData($client, $method, $uri, $options);
    }
    
}