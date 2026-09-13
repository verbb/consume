# Selecting a Client

Choose the configured client for the API you want to call. Use its handle in templates so the lookup does not depend on a database ID. In this example, configure a client whose handle is `catalogue` first:

```twig
{% set client = craft.consume.getClientByHandle('catalogue') %}
{% if client %}
    {# Use this client with the Fetching Data guide. #}
{% endif %}
```

## Calls Used in This Task

### `craft.consume.getAllClients()`
Returns a collection of [Client](docs:developers/client) objects.

### `craft.consume.getAllEnabledClients()`
Returns a collection of enabled [Client](docs:developers/client) objects.

### `craft.consume.getAllConfiguredClients()`
Returns a collection of configured [Client](docs:developers/client) objects.

### `craft.consume.getClientById(id)`
Returns a [Client](docs:developers/client) object by its ID.

### `craft.consume.getClientByHandle(handle)`
Returns a [Client](docs:developers/client) object by its handle.

### `craft.consume.fetchData(client, method, uri, options)`
Returns data from your client. See [Fetching Data](docs:template-guides/fetching-data) for further docs.
