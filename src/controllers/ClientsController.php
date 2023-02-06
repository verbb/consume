<?php
namespace verbb\consume\controllers;

use verbb\consume\Consume;
use verbb\consume\base\ClientInterface;

use Craft;
use craft\helpers\ArrayHelper;
use craft\helpers\Json;
use craft\web\Controller;

use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ClientsController extends Controller
{
    // Public Methods
    // =========================================================================

    public function actionIndex(): Response
    {
        $clients = Consume::$plugin->getClients()->getAllClients();

        return $this->renderTemplate('consume/clients', [
            'clients' => $clients,
        ]);
    }

    public function actionEditCredentials(?string $handle = null, ClientInterface $client = null): Response
    {
        return $this->_edit('credentials', $handle, $client);
    }

    public function actionEditOauth(?string $handle = null, ClientInterface $client = null): Response
    {
        return $this->_edit('oauth', $handle, $client);
    }

    public function actionSave(): ?Response
    {
        $this->requirePostRequest();

        $clientsService = Consume::$plugin->getClients();
        $clientId = $this->request->getParam('clientId') ?: null;
        $type = $this->request->getParam('type');

        if ($clientId) {
            $oldClient = $clientsService->getClientById($clientId);
            
            if (!$oldClient) {
                throw new BadRequestHttpException("Invalid client ID: $clientId");
            }
        }

        $client = $clientsService->createClient([
            'id' => $clientId,
            'type' => $type,
            'name' => $this->request->getParam('name'),
            'handle' => $this->request->getParam('handle'),
            'enabled' => (bool)$this->request->getParam('enabled'),
            'settings' => $this->request->getParam("types.$type"),
        ]);

        if (!$clientsService->saveClient($client)) {
            return $this->asModelFailure($client, Craft::t('consume', 'Couldn’t save client.'), 'client');
        }

        return $this->asModelSuccess($client, Craft::t('consume', 'Client saved.'), 'client');
    }

    public function actionReorder(): Response
    {
        $this->requirePostRequest();
        $this->requireAcceptsJson();

        $clientIds = Json::decode($this->request->getRequiredBodyParam('ids'));
        Consume::$plugin->getClients()->reorderClients($clientIds);

        return $this->asSuccess();
    }

    public function actionDelete(): Response
    {
        $this->requirePostRequest();
        $this->requireAcceptsJson();

        $clientId = $this->request->getRequiredBodyParam('id');

        Consume::$plugin->getClients()->deleteClientById($clientId);

        return $this->asSuccess();
    }

    public function actionRefreshSettings(): Response
    {
        $this->requireAcceptsJson();

        $clientsService = Consume::$plugin->getClients();

        $clientHandle = $this->request->getRequiredBodyParam('client');
        $setting = $this->request->getRequiredBodyParam('setting');

        $client = $clientsService->getClientByHandle($clientHandle);
        
        if (!$client) {
            throw new BadRequestHttpException("Invalid client: $clientHandle");
        }

        return $this->asJson($client->getClientSettings($setting, false));
    }


    // Private Methods
    // =========================================================================

    public function _edit(string $type, ?string $handle = null, ClientInterface $client = null): Response
    {
        $clientsService = Consume::$plugin->getClients();

        if ($client === null) {
            if ($handle !== null) {
                $client = $clientsService->getClientByHandle($handle);

                if ($client === null) {
                    throw new NotFoundHttpException('Client not found');
                }
            }
        }

        $allClientTypes = $clientsService->getAllClientTypes()[$type] ?? [];

        $clientInstances = [];
        $clientOptions = [];

        foreach ($allClientTypes as $clientType) {
            /** @var ClientInterface $clientInstance */
            $clientInstance = Craft::createObject($clientType);

            if ($client === null) {
                $client = $clientInstance;
            }

            $clientInstances[$clientType] = $clientInstance;

            $clientOptions[] = [
                'value' => $clientType,
                'label' => $clientInstance::displayName(),
            ];
        }

        // Sort them by name
        ArrayHelper::multisort($clientOptions, 'label');

        if ($handle && $clientsService->getClientByHandle($handle)) {
            $title = trim($client->name) ?: Craft::t('consume', 'Edit Client');
        } else {
            $title = Craft::t('consume', 'Create a new client');
        }

        return $this->renderTemplate("consume/clients/$type/_edit", [
            'title' => $title,
            'client' => $client,
            'clientOptions' => $clientOptions,
            'clientInstances' => $clientInstances,
            'clientTypes' => $allClientTypes,
        ]);
    }
}
