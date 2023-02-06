# Events
Consume provides a collection of events for extending its functionality. Modules and plugins can register event listeners, typically in their `init()` methods, to modify Consume’s behavior.

## Client Events

### The `beforeSaveClient` event
The event that is triggered before a client is saved.

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

### The `afterSaveClient` event
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

### The `beforeDeleteClient` event
The event that is triggered before a client is deleted.

```php
use verbb\consume\events\ClientEvent;
use verbb\consume\services\Clients;
use yii\base\Event;

Event::on(Clients::class, Clients::EVENT_BEFORE_DELETE_CLIENT, function(ClientEvent $event) {
    $client = $event->client;
    // ...
});
```

### The `afterDeleteClient` event
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
