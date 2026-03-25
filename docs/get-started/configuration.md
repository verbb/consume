# Configuration
Create a `consume.php` file under your `/config` directory with the following options available to you. You can also use multi-environment options to change these per environment.

The below shows the defaults already used by Consume, so you don't need to add these options unless you want to modify the values.

```php
<?php

return [
    '*' => [
        'pluginName' => 'Consume',
        'enableCache' => true,
        'cacheDuration' => 'PT1H',
        'redirectUri' => null,
    ]
];
```

## Configuration options
- `pluginName` - If you wish to customise the plugin name.
- `enableCache` - Whether to enable the cache for data.
- `cacheDuration` - When the cache is enabled, how long data is cached for. Accepts a [Date Interval](https://www.php.net/manual/en/dateinterval.construct.php) or a number of seconds.
- `redirectUri` - Optionally override the OAuth redirect URI for detached or multi-domain setups. This applies to all OAuth clients.

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
