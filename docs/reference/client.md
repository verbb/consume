# Client
Whenever you're dealing with a client in your template, you're actually working with a `Client` object.

<span id="attributes"></span>

## Properties

::: reference
### `name`

**Type:** `string|null`

The name of the client.
:::

::: reference
### `handle`

**Type:** `string|null`

The handle of the client.
:::

::: reference
### `enabled`

**Type:** `bool|null`

Whether the client is enabled or not.
:::

::: reference
### `type`

**Type:** `string`

The type of client this is (`oauth` or `credentials`).
:::

::: reference
### `primaryColor`

**Type:** `string|null`

The primary brand color of the provider connected.
:::

::: reference
### `icon`

**Type:** `string|null`

The SVG icon of the client provider connected.
:::

::: reference
### `providerName`

**Type:** `string`

The name of the client provider connected.
:::



## Methods

::: reference
### `isConfigured()`

**Returns:** `bool`

Returns whether the client has the settings it needs to make requests, such as a URL for a Generic credentials client, or a client ID and secret for an OAuth client.
:::

::: reference
### `isConnected()`

**Returns:** `bool`

Returns whether the client has a stored access token. This is always `false` for credentials clients.
:::

::: reference
### `getToken()`

**Returns:** `verbb\auth\models\Token|null`

Returns the stored access token for an OAuth client, or `null` when the client isn’t connected.
:::
