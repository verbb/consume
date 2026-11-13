# Custom Client Types

A client type defines how Consume connects to an API and what settings a client of that type has. Create your own when a service isn’t in the [list of providers](docs:providers/all-providers) and the Generic client types can’t authenticate with it, or when you want an existing client type with different defaults.

Client types are either `credentials` clients, which make plain HTTP requests with whatever URL, headers or keys you configure, or `oauth` clients, which connect through an OAuth 2 flow and store a token. Decide which one the service needs before you start.

## Create the Client Type Class

A credentials client extends `verbb\consume\base\CredentialsClient`. This example adds an API key setting and sends it as a header with every request.

```php
<?php
namespace modules\sitemodule;

use Craft;
use craft\helpers\App;
use verbb\consume\base\CredentialsClient;

class MyCredentialsClient extends CredentialsClient
{
    public static string $providerHandle = 'myCredentialsClient';

    public ?string $apiKey = null;

    public static function displayName(): string
    {
        return 'My Service';
    }

    public function isConfigured(): bool
    {
        return (bool)$this->apiKey;
    }

    public function getCredentialsProviderConfig(): array
    {
        return array_merge([
            'base_uri' => 'https://api.example.com/v1/',
            'headers' => [
                'X-Api-Key' => App::parseEnv($this->apiKey),
            ],
        ], $this->getProviderOptions());
    }

    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate(
            'site-module/my-client/settings',
            $this->getSettingsHtmlVariables(),
        );
    }
}
```

Each public property you add, such as `apiKey`, is saved with the client’s settings. `getCredentialsProviderConfig()` returns the configuration for the Guzzle client that makes each request. Merging `getProviderOptions()` keeps any options passed from a template, as the Generic client does.

## Register the Client Type

Consume finds client types through the `registerClientTypes` event. Register your class from your module or plugin’s `init()` method.

```php
use modules\sitemodule\MyCredentialsClient;
use modules\sitemodule\MyOAuthClient;
use verbb\consume\events\RegisterClientsEvent;
use verbb\consume\services\Clients;
use yii\base\Event;

Event::on(Clients::class, Clients::EVENT_REGISTER_CLIENT_TYPES, function(RegisterClientsEvent $event) {
    $event->credentials[] = MyCredentialsClient::class;
    $event->oauth[] = MyOAuthClient::class;
});
```

Add a credentials client to `credentials` and an OAuth client to `oauth`. The new type then appears when you create a client of that kind.

## OAuth Clients

An OAuth client extends `verbb\consume\base\OAuthClient` and returns its provider class from `getOAuthProviderClass()`. Consume handles the client ID, client secret, scopes, connection and token storage.

```php
<?php
namespace modules\sitemodule;

use Craft;
use verbb\auth\providers\GitHub as GitHubProvider;
use verbb\consume\base\OAuthClient;

class MyOAuthClient extends OAuthClient
{
    public static string $providerHandle = 'myOAuthClient';

    public static function displayName(): string
    {
        return 'My OAuth Service';
    }

    public static function getOAuthProviderClass(): string
    {
        return GitHubProvider::class;
    }

    public function getSettingsHtml(): ?string
    {
        $this->normalizeScopes();

        return Craft::$app->getView()->renderTemplate(
            'site-module/my-oauth-client/settings',
            $this->getSettingsHtmlVariables(),
        );
    }
}
```

Consume is built on [Auth](https://github.com/verbb/auth), which wraps [league/oauth2-client](https://github.com/thephpleague/oauth2-client). The provider class must be an OAuth 2 provider that uses Auth’s `verbb\auth\base\ProviderTrait` and implements `getBaseApiUrl()`, which returns the URL that request paths are relative to. Auth’s own providers in `verbb\auth\providers` already do this. OAuth 1 providers aren’t supported.

## Settings Templates

The built-in client types render their settings from Consume’s own templates, named after `$providerHandle`. A custom class must override `getSettingsHtml()` and render a template from a control panel template root your module registers. Passing `getSettingsHtmlVariables()` gives the template the `client` variable, and each input’s `name` should match a public property on your class, such as `apiKey`. An OAuth client’s template can include `consume/clients/oauth/_oauth` to show the standard Redirect URI, Client ID, Client Secret and Scopes fields. See Craft’s [template root documentation](https://craftcms.com/docs/5.x/extend/template-roots.html).

## Methods

These are the methods a client type class commonly implements or overrides.

::: reference
### `displayName()`

**Returns:** `string`

Static. Returns the name shown when choosing a client type and as the client’s provider name.
:::

::: reference
### `getOAuthProviderClass()`

**Returns:** `string`

Static, OAuth clients only. Returns the class name of the OAuth 2 provider that handles authorisation and requests.
:::

::: reference
### `getCredentialsProviderConfig()`

**Returns:** `array`

Credentials clients only. Returns the Guzzle configuration, such as `base_uri`, `headers` and `auth`, for the client that makes each request.
:::

::: reference
### `getCredentialsProviderOptions(array $options = [])`

**Returns:** `array`

Credentials clients only. Receives the request options for a single request and returns them with any additions, such as query string parameters.
:::

::: reference
### `getSettingsHtml()`

**Returns:** `string|null`

Returns the settings fields shown when editing a client of this type.
:::

::: reference
### `isConfigured()`

**Returns:** `bool`

Returns whether the client has the settings it needs to make requests. Credentials clients return `false` by default, and OAuth clients return whether a client ID and secret are set.
:::

::: reference
### `getPrimaryColor()`

**Returns:** `string|null`

Returns the brand colour shown for the client. The default looks it up from Auth by `$providerHandle`.
:::

::: reference
### `getIcon()`

**Returns:** `string|null`

Returns the SVG icon shown for the client. The default looks it up from Auth by `$providerHandle`.
:::
