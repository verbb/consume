<?php
namespace verbb\consume\services;

use verbb\consume\base\Client;
use verbb\consume\base\ClientInterface;
use verbb\consume\clients\credentials as credentialTypes;
use verbb\consume\clients\oauth as oauthTypes;
use verbb\consume\clients\MissingClient;
use verbb\consume\events\ClientEvent;
use verbb\consume\events\RegisterClientsEvent;
use verbb\consume\records\Client as ClientRecord;

use Craft;
use craft\base\MemoizableArray;
use craft\db\Query;
use craft\errors\MissingComponentException;
use craft\events\RegisterComponentTypesEvent;
use craft\helpers\ArrayHelper;
use craft\helpers\Component as ComponentHelper;
use craft\helpers\Json;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\caching\TagDependency;

use Exception;
use Throwable;

class Clients extends Component
{
    // Constants
    // =========================================================================

    public const EVENT_REGISTER_CLIENT_TYPES = 'registerClientTypes';
    public const EVENT_BEFORE_SAVE_CLIENT = 'beforeSaveClient';
    public const EVENT_AFTER_SAVE_CLIENT = 'afterSaveClient';
    public const EVENT_BEFORE_DELETE_CLIENT = 'beforeDeleteClient';
    public const EVENT_AFTER_DELETE_CLIENT = 'afterDeleteClient';


    // Properties
    // =========================================================================

    private ?MemoizableArray $_clients = null;
    private ?array $_overrides = null;


    // Public Methods
    // =========================================================================

    public function getAllClientTypes(): array
    {
        $credentialsTypes = [
            credentialTypes\Generic::class,
        ];

        $oauthTypes = [
            oauthTypes\Generic::class,
            oauthTypes\Azure::class,
            oauthTypes\Amazon::class,
            oauthTypes\Apple::class,
            oauthTypes\Auth0::class,
            oauthTypes\Aweber::class,
            oauthTypes\Basecamp::class,
            oauthTypes\Bitbucket::class,
            oauthTypes\Box::class,
            oauthTypes\Buddy::class,
            oauthTypes\Buffer::class,
            oauthTypes\ConstantContact::class,
            oauthTypes\Deezer::class,
            oauthTypes\DeviantArt::class,
            oauthTypes\Discord::class,
            oauthTypes\Disqus::class,
            oauthTypes\Docusign::class,
            oauthTypes\Dribbble::class,
            oauthTypes\Drip::class,
            oauthTypes\Dropbox::class,
            oauthTypes\Envato::class,
            oauthTypes\Etsy::class,
            oauthTypes\Eventbrite::class,
            oauthTypes\Facebook::class,
            oauthTypes\Fedex::class,
            oauthTypes\Fitbit::class,
            oauthTypes\Foursquare::class,
            oauthTypes\FreshBooks::class,
            oauthTypes\GitHub::class,
            oauthTypes\GitLab::class,
            oauthTypes\Google::class,
            oauthTypes\GoToWebinar::class,
            oauthTypes\Gumroad::class,
            oauthTypes\Harvest::class,
            oauthTypes\Heroku::class,
            oauthTypes\HubSpot::class,
            oauthTypes\Imgur::class,
            oauthTypes\Infusionsoft::class,
            oauthTypes\Instagram::class,
            oauthTypes\Jira::class,
            oauthTypes\Line::class,
            oauthTypes\LinkedIn::class,
            oauthTypes\Linode::class,
            oauthTypes\Mailchimp::class,
            oauthTypes\Mailru::class,
            oauthTypes\Marketo::class,
            oauthTypes\Mastodon::class,
            oauthTypes\Meetup::class,
            oauthTypes\Microsoft::class,
            oauthTypes\Mollie::class,
            oauthTypes\Odnoklassniki::class,
            oauthTypes\PayPal::class,
            oauthTypes\Pinterest::class,
            oauthTypes\Pipedrive::class,
            oauthTypes\Reddit::class,
            oauthTypes\Salesforce::class,
            oauthTypes\Shopify::class,
            oauthTypes\Slack::class,
            oauthTypes\Snapchat::class,
            oauthTypes\SoundCloud::class,
            oauthTypes\Spotify::class,
            oauthTypes\Square::class,
            oauthTypes\StackExchange::class,
            oauthTypes\Strava::class,
            oauthTypes\Stripe::class,
            oauthTypes\Sugarcrm::class,
            oauthTypes\TikTok::class,
            oauthTypes\Trello::class,
            oauthTypes\Trustpilot::class,
            oauthTypes\Tumblr::class,
            oauthTypes\Twitch::class,
            oauthTypes\Twitter::class,
            oauthTypes\Uber::class,
            oauthTypes\Unsplash::class,
            oauthTypes\Vend::class,
            oauthTypes\Vimeo::class,
            oauthTypes\Vkontakte::class,
            oauthTypes\WeChat::class,
            oauthTypes\Weibo::class,
            oauthTypes\Yahoo::class,
            oauthTypes\Yelp::class,
            oauthTypes\Zendesk::class,
            oauthTypes\Zoho::class,
        ];

        $event = new RegisterClientsEvent([
            Client::TYPE_CREDENTIALS => $credentialsTypes,
            Client::TYPE_OAUTH => $oauthTypes,
        ]);

        $this->trigger(self::EVENT_REGISTER_CLIENT_TYPES, $event);

        return [
            Client::TYPE_CREDENTIALS => $event->credentials,
            Client::TYPE_OAUTH => $event->oauth,
        ];
    }

    public function createClient(mixed $config): ClientInterface
    {
        $handle = $config['handle'] ?? null;
        $settings = $config['settings'] ?? [];

        // Allow config settings to override client settings
        if ($handle && $settings) {
            $configOverrides = $this->getClientOverrides($handle);

            if ($configOverrides) {
                if (is_string($settings)) {
                    $settings = Json::decode($settings);
                }

                $config['settings'] = array_merge($settings, $configOverrides);
            }
        }                

        try {
            return ComponentHelper::createComponent($config, ClientInterface::class);
        } catch (MissingComponentException|InvalidConfigException $e) {
            $config['errorMessage'] = $e->getMessage();
            $config['expectedType'] = $config['type'];
            unset($config['type']);
            return new MissingClient($config);
        }
    }

    public function getAllClients(): array
    {
        return $this->_clients()->all();
    }

    public function getAllEnabledClients(): array
    {
        return $this->_clients()->where('enabled', true)->all();
    }

    public function getAllConfiguredClients(): array
    {
        $clients = [];

        foreach ($this->getAllEnabledClients() as $client) {
            if ($client->isConfigured()) {
                $clients[] = $client;
            }
        }

        return $clients;
    }

    public function getAllClientsByParams(array $params): array
    {
        $limit = ArrayHelper::remove($params, 'limit');

        $query = $this->_createClientQuery()->where($params)->limit($limit)->all();

        return array_map(function($result) {
            return $this->createClient($result);
        }, $query);
    }

    public function getClientById(int $id, bool $enabledOnly = false, bool $connectedOnly = false): ?ClientInterface
    {
        $client = $this->_clients()->firstWhere('id', $id);

        if ($client && (($enabledOnly && !$client->enabled) || ($connectedOnly && !$client->isConnected()))) {
            return null;
        }

        return $client;
    }

    public function getClientByHandle(string $handle, bool $enabledOnly = false, bool $connectedOnly = false): ?ClientInterface
    {
        $client = $this->_clients()->firstWhere('handle', $handle, true);
    
        if ($client && (($enabledOnly && !$client->enabled) || ($connectedOnly && !$client->isConnected()))) {
            return null;
        }

        return $client;
    }

    public function getClientByParams(array $params): ?ClientInterface
    {
        $params['limit'] = 1;

        return $this->getAllClientsByParams($params)[0] ?? null;
    }

    public function saveClient(ClientInterface $client, bool $runValidation = true): bool
    {
        $isNewClient = !$client->id;

        // Fire a 'beforeSaveClient' event
        if ($this->hasEventHandlers(self::EVENT_BEFORE_SAVE_CLIENT)) {
            $this->trigger(self::EVENT_BEFORE_SAVE_CLIENT, new ClientEvent([
                'client' => $client,
                'isNew' => $isNewClient,
            ]));
        }

        if (!$client->beforeSave($isNewClient)) {
            return false;
        }

        if ($runValidation && !$client->validate()) {
            Craft::info('Client not saved due to validation error.', __METHOD__);
            return false;
        }

        // Ensure we support Emoji's properly
        $settings = $client->settings;

        $clientRecord = $this->_getClientRecordById($client->id);
        $clientRecord->name = $client->name;
        $clientRecord->handle = $client->handle;
        $clientRecord->enabled = $client->enabled;
        $clientRecord->type = get_class($client);
        $clientRecord->settings = $settings;

        if ($isNewClient) {
            $maxSortOrder = (new Query())
                ->from(['{{%consume_clients}}'])
                ->max('[[sortOrder]]');

            $clientRecord->sortOrder = $maxSortOrder ? $maxSortOrder + 1 : 1;
        }

        $clientRecord->save(false);

        if (!$client->id) {
            $client->id = $clientRecord->id;
        }

        $client->afterSave($isNewClient);

        TagDependency::invalidate(Craft::$app->getCache(), ['consume:' . $client->handle]);

        // Fire an 'afterSaveClient' event
        if ($this->hasEventHandlers(self::EVENT_AFTER_SAVE_CLIENT)) {
            $this->trigger(self::EVENT_AFTER_SAVE_CLIENT, new ClientEvent([
                'client' => $client,
                'isNew' => $isNewClient,
            ]));
        }

        return true;
    }

    public function reorderClients(array $clientIds): bool
    {
        $transaction = Craft::$app->getDb()->beginTransaction();

        try {
            foreach ($clientIds as $clientOrder => $clientId) {
                $clientRecord = $this->_getClientRecordById($clientId);
                $clientRecord->sortOrder = $clientOrder + 1;
                $clientRecord->save();
            }

            $transaction->commit();
        } catch (Throwable $e) {
            $transaction->rollBack();

            throw $e;
        }

        return true;
    }

    public function getClientOverrides(string $handle): array
    {
        if ($this->_overrides === null) {
            $this->_overrides = Craft::$app->getConfig()->getConfigFromFile('consume');
        }

        return $this->_overrides['clients'][$handle] ?? [];
    }

    public function deleteClientById(int $clientId): bool
    {
        $client = $this->getClientById($clientId);

        if (!$client) {
            return false;
        }

        return $this->deleteClient($client);
    }

    public function deleteClient(ClientInterface $client): bool
    {
        // Fire a 'beforeDeleteClient' event
        if ($this->hasEventHandlers(self::EVENT_BEFORE_DELETE_CLIENT)) {
            $this->trigger(self::EVENT_BEFORE_DELETE_CLIENT, new ClientEvent([
                'client' => $client,
            ]));
        }

        Craft::$app->getDb()->createCommand()
            ->delete('{{%consume_clients}}', ['id' => $client->id])
            ->execute();

        // Fire an 'afterDeleteClient' event
        if ($this->hasEventHandlers(self::EVENT_AFTER_DELETE_CLIENT)) {
            $this->trigger(self::EVENT_AFTER_DELETE_CLIENT, new ClientEvent([
                'client' => $client,
            ]));
        }

        // Clear caches
        $this->_clients = null;

        return true;
    }


    // Private Methods
    // =========================================================================

    private function _clients(): MemoizableArray
    {
        if (!isset($this->_clients)) {
            $clients = [];

            foreach ($this->_createClientQuery()->all() as $result) {
                $clients[] = $this->createClient($result);
            }

            $this->_clients = new MemoizableArray($clients);
        }

        return $this->_clients;
    }

    private function _createClientQuery(): Query
    {
        return (new Query())
            ->select([
                'id',
                'name',
                'handle',
                'enabled',
                'type',
                'settings',
                'sortOrder',
                'cache',
                'dateCreated',
                'dateUpdated',
                'uid',
            ])
            ->from(['{{%consume_clients}}'])
            ->orderBy(['sortOrder' => SORT_ASC]);
    }

    private function _getClientRecordById(int $clientId = null): ?ClientRecord
    {
        if ($clientId !== null) {
            $clientRecord = ClientRecord::findOne(['id' => $clientId]);

            if (!$clientRecord) {
                throw new Exception(Craft::t('consume', 'No client exists with the ID “{id}”.', ['id' => $clientId]));
            }
        } else {
            $clientRecord = new ClientRecord();
        }

        return $clientRecord;
    }

}
