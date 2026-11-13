# Events

Consume provides events for extending its functionality. Modules and plugins can register event listeners, typically in their `init()` methods, to change Consume’s behaviour.

## Client Events

### The `registerClientTypes` Event
The event that is triggered when Consume gathers the available client types. Add your own class to `oauth` or `credentials` to make it available when creating a client. See [Custom Client Types](docs:developers/custom-client-types).

```php
use modules\sitemodule\MyCredentialsClient;
use verbb\consume\events\RegisterClientsEvent;
use verbb\consume\services\Clients;
use yii\base\Event;

Event::on(Clients::class, Clients::EVENT_REGISTER_CLIENT_TYPES, function(RegisterClientsEvent $event) {
    $event->credentials[] = MyCredentialsClient::class;
});
```

### The `beforeSaveClient` Event
The event that is triggered before a client is saved.

The listener can change the client’s properties before it’s validated and saved. The event can’t prevent the save.

```php
use verbb\consume\events\ClientEvent;
use verbb\consume\services\Clients;
use yii\base\Event;

Event::on(Clients::class, Clients::EVENT_BEFORE_SAVE_CLIENT, function(ClientEvent $event) {
    $client = $event->client;
    $isNew = $event->isNew;
    // ...
});
```

### The `afterSaveClient` Event
The event that is triggered after a client is saved.

```php
use verbb\consume\events\ClientEvent;
use verbb\consume\services\Clients;
use yii\base\Event;

Event::on(Clients::class, Clients::EVENT_AFTER_SAVE_CLIENT, function(ClientEvent $event) {
    $client = $event->client;
    $isNew = $event->isNew;
    // ...
});
```

### The `beforeDeleteClient` Event
The event that is triggered before a client is deleted.

The event can’t prevent the deletion.

```php
use verbb\consume\events\ClientEvent;
use verbb\consume\services\Clients;
use yii\base\Event;

Event::on(Clients::class, Clients::EVENT_BEFORE_DELETE_CLIENT, function(ClientEvent $event) {
    $client = $event->client;
    // ...
});
```

### The `afterDeleteClient` Event
The event that is triggered after a client is deleted.

```php
use verbb\consume\events\ClientEvent;
use verbb\consume\services\Clients;
use yii\base\Event;

Event::on(Clients::class, Clients::EVENT_AFTER_DELETE_CLIENT, function(ClientEvent $event) {
    $client = $event->client;
    // ...
});
```

## Data Events

### The `beforeFetchData` Event
The event that is triggered before Consume fetches data, such as from `craft.consume.fetchData()`, and before it checks the cache.

The listener can change the request through the event’s `clientOpts` (the client handle or options), `method`, `uri` and `options` properties, and Consume uses the changed values for the cache lookup and the request. To skip the request, set `$event->isValid` to `false` and Consume returns `$event->response` instead, without reading or writing the cache.

```php
use verbb\consume\events\FetchEvent;
use verbb\consume\services\Service;
use yii\base\Event;

Event::on(Service::class, Service::EVENT_BEFORE_FETCH_DATA, function(FetchEvent $event) {
    // Return a fixed response for one endpoint
    if ($event->clientOpts === 'myClient' && $event->uri === 'status') {
        $event->response = ['status' => 'ok'];
        $event->isValid = false;
    }
});
```
