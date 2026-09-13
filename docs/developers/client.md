# Client
Whenever you're dealing with an client in your template, you're actually working with a `Client` object.

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

Whether the client provider has been configured.
:::

::: reference
### `isConnected()`

**Returns:** `bool`

Whether the client provider has been connected and has a token. (OAuth clients only).
:::

::: reference
### `getToken()`

The access token for a client provider. (OAuth clients only).
:::
