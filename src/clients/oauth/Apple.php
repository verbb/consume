<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use Craft;
use craft\helpers\App;
use craft\helpers\FileHelper;

use verbb\auth\Auth;
use verbb\auth\providers\Apple as AppleProvider;

class Apple extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return AppleProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'apple';
    public ?string $teamId = null;
    public ?string $keyFileId = null;
    public ?string $keyFilePath = null;


    // Public Methods
    // =========================================================================

    public function getTeamId(): ?string
    {
        return App::parseEnv($this->teamId);
    }

    public function getKeyFileId(): ?string
    {
        return App::parseEnv($this->keyFileId);
    }

    public function getKeyFilePath(): ?string
    {
        return App::parseEnv($this->keyFilePath);
    }

    public function defineRules(): array
    {
        $rules = parent::defineRules();
        $rules[] = [['clientId', 'teamId', 'keyFileId', 'keyFilePath'], 'required'];

        return $rules;
    }

    public function isConfigured(): bool
    {
        return $this->clientId && $this->teamId && $this->keyFileId && $this->keyFilePath;
    }

    public function getSettingsHtml(): ?string
    {
        $keyFilePaths = [];
        $path = Craft::$app->getPath()->getConfigPath() . DIRECTORY_SEPARATOR . 'consume';

        if (is_dir($path)) {
            $files = FileHelper::findFiles($path, [
                'only' => ['*.*'],
                'recursive' => false,
            ]);

            foreach ($files as $file) {
                $filename = basename($file);

                $keyFilePaths[] = [
                    'name' => $file,
                    'hint' => $filename,
                ];
            }
        }

        if ($keyFilePaths) {
            $keyFilePaths = [[
                'label' => 'Key Files',
                'data' => $keyFilePaths,
            ]];
        }

        return Craft::$app->getView()->renderTemplate('consume/clients/oauth/_types/apple', [
            'client' => $this,
            'suggestions' => $keyFilePaths,
        ]);
    }

    public function getOAuthProviderConfig(): array
    {
        return [
            'clientId' => $this->getClientId(),
            'teamId' => $this->getTeamId(),
            'keyFileId' => $this->getKeyFileId(),
            'keyFilePath' => $this->getKeyFilePath(),
            'redirectUri' => $this->getRedirectUri(),
        ];
    }

}