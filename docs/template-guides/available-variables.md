# Available Variables
The following are common methods you will want to call in your front end templates:

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
