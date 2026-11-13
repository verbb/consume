# Selecting a Client

Choose the configured client for the API you want to call. Use its handle in templates so the lookup does not depend on a database ID. In this example, configure a client whose handle is `catalogue` first:

```twig
{% set client = craft.consume.getClientByHandle('catalogue') %}

{% if client and client.enabled and client.isConfigured() %}
    {% set products = craft.consume.fetchData(client.handle, 'GET', 'products') %}
{% endif %}
```

Checking the client first lets you show a fallback, such as a "temporarily unavailable" message, when someone disables the client or clears its settings. For an OAuth client, also check `client.isConnected()`, which is `false` until someone has connected the client to the provider.

## Listing Clients

`craft.consume.getAllClients()` returns an array of every [Client](docs:reference/client) object, including disabled clients and clients that are missing settings. It takes no arguments.

`craft.consume.getAllEnabledClients()` returns an array of the [Client](docs:reference/client) objects that are enabled. It takes no arguments.

`craft.consume.getAllConfiguredClients()` returns an array of the enabled [Client](docs:reference/client) objects that have the settings they need to make requests. A Generic credentials client needs a URL, and an OAuth client needs its client ID and secret (Apple also needs its team ID and key file). It takes no arguments.

A configured OAuth client isn't necessarily connected yet, so use `client.isConnected()` when you need to know whether it can make requests. This example lists the configured clients with their connection status, which can help when you're testing a development installation.

```twig
<ul>
    {% for client in craft.consume.getAllConfiguredClients() %}
        <li>
            {{ client.name }} ({{ client.handle }})

            {% if client.type == 'oauth' %}
                {{ client.isConnected() ? 'Connected' : 'Not connected' }}
            {% endif %}
        </li>
    {% else %}
        <li>No clients are ready to use.</li>
    {% endfor %}
</ul>
```

## Getting One Client

`craft.consume.getClientById(id)` returns the [Client](docs:reference/client) object with the given ID, or `null` if there isn't one. `id` is required. The client is returned even when it's disabled, so check `client.enabled` if that matters to your template.

```twig
{% set client = craft.consume.getClientById(4) %}
```

`craft.consume.getClientByHandle(handle)` returns the [Client](docs:reference/client) object with the given handle, or `null` if there isn't one. `handle` is required and must match the client's handle exactly, including its case. Like `getClientById()`, it returns disabled clients too.

```twig
{% set client = craft.consume.getClientByHandle('catalogue') %}

{% if client %}
    <p>Showing products from {{ client.name }}.</p>
{% endif %}
```

## Fetching Data With a Client

`craft.consume.fetchData(client, method, uri, options)` makes a request with a client and returns the parsed response, or `null` if the request fails. `client` is required and is either a client's handle or a hash with a `handle` and any extra settings. `method` defaults to `GET`, `uri` to an empty string (the client's base URL) and `options` to an empty hash of Guzzle request options. Only enabled clients can make requests.

```twig
{% set products = craft.consume.fetchData('catalogue', 'GET', 'products', {
    query: {
        limit: 10,
    },
}) %}
```

See [Fetching Data](docs:template-guides/fetching-data) for the request options, error handling, response formats and on-demand clients.
