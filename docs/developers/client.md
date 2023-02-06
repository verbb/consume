# Client
Whenever you're dealing with an client in your template, you're actually working with a `Client` object.

## Attributes

Attribute | Description
--- | ---
`name` | The name of the client.
`handle` | The handle of the client.
`enabled` | Whether the client is enabled or not.
`type` | The type of client this is (`oauth` or `credentials`).
`primaryColor` | The primary brand color of the provider connected.
`icon` | The SVG icon of the client provider connected.
`providerName` | The name of the client provider connected.


## Methods

Method | Description
--- | ---
`isConfigured()` | Whether the client provider has been configured.
`isConnected()` | Whether the client provider has been connected and has a token. (OAuth clients only).
`getToken()` | The access token for a client provider. (OAuth clients only).
