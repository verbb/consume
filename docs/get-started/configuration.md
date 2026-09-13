# Configuration

You can customise Consume’s settings using a PHP configuration file. This is optional: each setting has a default, so you only need to include the values you want to change.

To override a setting, create `consume.php` in your Craft project’s `/config` directory and return an array of setting names and values. For example, the following will change the name displayed in the control panel:

```php
<?php

return [
    'pluginName' => 'Consume Tools',
];
```

All other settings keep their defaults. Add any further settings you want to change to the same array. The options below explain the available settings and their defaults.

## Configuration Options

::: reference
### `pluginName`

**Type:** `string` · **Default:** `'Consume'`

The name displayed for the plugin in the control panel.
:::

::: reference
### `enableCache`

**Type:** `bool` · **Default:** `true`

Whether to enable the cache for data.
:::

::: reference
### `cacheDuration`

**Type:** `mixed` · **Default:** `'PT1H'`

When the cache is enabled, how long data is cached for. Accepts a [Date Interval](https://www.php.net/manual/en/dateinterval.construct.php) or a number of seconds.
:::

::: reference
### `redirectUri`

**Type:** `string|null` · **Default:** `null`

Optionally override the OAuth redirect URI for detached or multi-domain setups. This applies to all OAuth clients.
:::


### Redirect URI Override
By default, Consume will continue to use its legacy callback URI. If you need to use a different callback URI, such as for detached domains or an `/actions/...` callback, set `redirectUri` at the plugin level.

```php
'redirectUri' => 'https://craft.example.com/actions/consume/auth/callback',
```

### Clients
Supply your client configurations as per the below. The `key` for each item should be the client `handle`. Do note that this only allows overriding existing clients and their settings, and you can't define clients purely in the configuration file.

```php
return [
    'clients' => [
        'facebook' => [
            'enabled' => true,
            'clientId' => 'xxxxxxxxxxxx',
            'clientSecret' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
        ],
        'myCustomClient' => [
            'url' => 'https://my-app.test/some/path',

            // Add any query params for the client
            'queryParams' => [
                'limit' => '10',
            ],

            // Add any headers for the client
            'headers' => [
                'api-key' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
            ],

            // If your client needs to use HTTP Basic Auth...
            'httpAuth' => [
                'username' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                'password' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
            ],
        ],
    ],
];
```

## Control Panel
You can also manage configuration settings through the Control Panel by visiting Settings → Consume.
