<?php
namespace verbb\consume\clients\credentials;

use verbb\consume\base\CredentialsClient;

use craft\helpers\App;

use verbb\auth\helpers\UrlHelper as AuthUrlHelper;

class Generic extends CredentialsClient
{
    // Properties
    // =========================================================================

    public static string $providerHandle = 'generic';
    public ?string $url = null;
    public array $queryParams = [];
    public array $headers = [];
    public array $httpAuth = [];


    // Public Methods
    // =========================================================================

    public function defineRules(): array
    {
        $rules = parent::defineRules();

        $rules[] = [
            ['url'], 'required', 'when' => function($model) {
                return $model->enabled;
            },
        ];

        return $rules;
    }

    public function isConfigured(): bool
    {
        return (bool)$this->url;
    }

    public function getCredentialsProviderOptions(array $options = []): array
    {
        foreach ($this->queryParams as $key => $value) {
            $options['query'][App::parseEnv($key)] = App::parseEnv($value);
        }

        return $options;
    }

    public function getCredentialsProviderConfig(): array
    {
        $url = App::parseEnv($this->url);

        $config = array_filter([
            'base_uri' => rtrim($url, '/'),
        ]);

        if ($this->headers) {
            foreach ($this->headers as $key => $value) {
                $config['headers'][App::parseEnv($key)] = App::parseEnv($value);
            }
        }

        if ($auth = array_filter(array_values($this->httpAuth))) {
            foreach ($auth as $value) {
                $config['auth'][] = App::parseEnv($value);
            }
        }

        // Merge in any additional config options set at the template level
        return array_merge($config, $this->getProviderOptions());
    }

    public function beforeSave(bool $isNew): bool
    {
        // Normalise editable table values
        if (isset($this->queryParams[0])) {
            $queryParams = [];

            foreach ($this->queryParams as $param) {
                $queryParams[$param['key']] = $param['value'];
            }

            $this->queryParams = $queryParams;
        }

        if (isset($this->headers[0])) {
            $headers = [];

            foreach ($this->headers as $header) {
                $headers[$header['key']] = $header['value'];
            }

            $this->headers = $headers;
        }

        if (isset($this->httpAuth[0])) {
            $this->httpAuth = [
                'username' => $this->httpAuth[0]['username'] ?? null,
                'password' => $this->httpAuth[0]['password'] ?? null,
            ];
        }

        return parent::beforeSave($isNew);
    }

}