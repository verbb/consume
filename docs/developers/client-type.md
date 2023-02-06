# Client Type
You can register your own Client Type to add support for other APIs, endpoints, or even extend an existing Client Type.

```php
use modules\MyClientProvider;

use verbb\consume\events\RegisterClientsEvent;
use verbb\consume\services\Clients;
use yii\base\Event;

Event::on(Clients::class, Clients::EVENT_REGISTER_CLIENT_TYPES, function(RegisterClientsEvent $event) {
    $event->oauth[] = MyOAuthClientProvider::class;
    $event->credentials[] = MyCredentialsClientProvider::class;
});
```

You'll need to decide whether to create an `oauth` or `credentials` client, depending on the authentication needed for your use-case.

## OAuth Example
Create the following class to house your Client Type logic.

```php
namespace modules;

use verbb\consume\base\OAuthClient;
use verbb\consume\models\Post;

use League\OAuth2\Client\Provider\SomeProvider;

class MyOAuthClientProvider extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function displayName(): string
    {
        return 'My OAuth Client';
    }

    public static function getOAuthProviderClass(): string
    {
        return SomeProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'myOAuthClient';


    // Public Methods
    // =========================================================================

    public function getPrimaryColor(): ?string
    {
        return '#000000';
    }

    public function getIcon(): ?string
    {
        return '<svg>...</svg>';
    }

    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('my-module/my-client/settings', [
            'client' => $this,
        ]);
    }
}
```

This is the minimum amount of implementation required for a typical OAuth client provider.

Consume client providers are built around the [Auth](https://github.com/verbb/auth) which in turn in built around [league/oauth2-client](https://github.com/thephpleague/oauth2-client). You can see that the `getOAuthProviderClass()` must return a `League\OAuth2\Client\Provider\AbstractProvider` class.

## Credentials Example
A Credentials client is similar to an OAuth one, without the need to provide a `getOAuthProviderClass()` class.

```php
namespace modules;

use verbb\consume\base\CredentialsClient;
use verbb\consume\models\Post;

class MyCredentialsClientProvider extends CredentialsClient
{
    // Static Methods
    // =========================================================================

    public static function displayName(): string
    {
        return 'My Credentials Client';
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'myCredentialsClient';


    // Public Methods
    // =========================================================================

    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('my-module/my-client/settings', [
            'client' => $this,
        ]);
    }
}
```

You'll likely want to add your own properties to store additional content, like a URL, API Keys, etc.

