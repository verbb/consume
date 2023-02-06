<?php
namespace verbb\consume\base;

use verbb\consume\Consume;

use Craft;
use craft\base\SavableComponent;
use craft\helpers\Json;
use craft\helpers\StringHelper;
use craft\helpers\UrlHelper;
use craft\validators\HandleValidator;

use verbb\auth\helpers\Provider as ProviderHelper;

use DateTime;
use Exception;

use GuzzleHttp\Exception\RequestException;

abstract class Client extends SavableComponent implements ClientInterface
{
    // Constants
    // =========================================================================

    public const TYPE_CREDENTIALS = 'credentials';
    public const TYPE_OAUTH = 'oauth';


    // Static Methods
    // =========================================================================

    public static function apiError($client, $exception, $throwError = true): void
    {
        $messageText = $exception->getMessage();

        // Check for Guzzle errors, which are truncated in the exception `getMessage()`.
        if ($exception instanceof RequestException && $exception->getResponse()) {
            $messageText = (string)$exception->getResponse()->getBody();
        }

        $message = Craft::t('consume', 'API error: “{message}” {file}:{line}', [
            'message' => $messageText,
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);

        Consume::error($client->name . ': ' . $message);

        if ($throwError) {
            throw new Exception($message);
        }
    }


    // Properties
    // =========================================================================

    public ?string $name = null;
    public ?string $handle = null;
    public ?bool $enabled = null;
    public ?int $sortOrder = null;
    public array $cache = [];
    public ?string $uid = null;

    protected array $providerOptions = [];


    // Public Methods
    // =========================================================================

    public function defineRules(): array
    {
        $rules = parent::defineRules();

        $rules[] = [['name', 'handle'], 'required'];
        $rules[] = [['id'], 'number', 'integerOnly' => true];

        $rules[] = [
            ['handle'],
            HandleValidator::class,
            'reservedWords' => [
                'dateCreated',
                'dateUpdated',
                'edit',
                'id',
                'title',
                'uid',
            ],
        ];

        return $rules;
    }

    public function getType(): string
    {
        return static::$type;
    }

    public function getTypeLabel(): string
    {
        return static::$typeLabel;
    }

    public function getProviderName(): string
    {
        return static::displayName();
    }

    public function getPrimaryColor(): ?string
    {
        return ProviderHelper::getPrimaryColor(static::$providerHandle);
    }

    public function getIcon(): ?string
    {
        return ProviderHelper::getIcon(static::$providerHandle);
    }

    public function getCpEditUrl(): string
    {
        return UrlHelper::cpUrl('consume/clients/' . $this->getType() . '/' . $this->handle);
    }

    public function isConnected(): bool
    {
        return false;
    }

    public function getProviderOptions(): array
    {
        return $this->providerOptions;
    }

    public function setProviderOptions(array $options = []): void
    {
        $this->providerOptions = $options;
    }

    public function getClientSettings(string $settingsKey, bool $useCache = true): ?array
    {
        if ($useCache) {
            // Return even if empty, we don't want to force setting the value unless told to
            return $this->getSettingCache($settingsKey);
        }

        $settings = $this->fetchClientSettings($settingsKey);

        if ($settings) {
            $this->setSettingCache([$settingsKey => $settings]);
        }

        return $settings;
    }

    public function fetchClientSettings(string $settingsKey): ?array
    {
        return [];
    }


    // Protected Methods
    // =========================================================================

    protected function setSettingCache(array $values): void
    {
        $this->cache = array_merge($this->cache, $values);

        $data = Json::encode($this->cache);

        // Direct DB update to keep it out of PC, plus speed
        Craft::$app->getDb()->createCommand()
            ->update('{{%consume_clients}}', ['cache' => $data], ['id' => $this->id])
            ->execute();
    }

    protected function getSettingCache(string $key): mixed
    {
        return $this->cache[$key] ?? null;
    }
}
