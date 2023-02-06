# Clients
You can create either a **Credentials** or **OAuth** client in Consume, via the control panel UI. This allows you to be able to set settings once, and use the client multiple times in your front-end Twig templates.

:::tip
You don't have to use clients if you just want to roll your own [Guzzle](https://docs.guzzlephp.org/en/stable/) client. Have a look at the [Requests](docs:template/guides/requests) docs. 

**However** you can't use OAuth-based clients in your templates. You'll need to create your own [Client](docs:developers/client-type).
:::

## Credentials Client
A Credentials client is used for the more traditional API, where you might authenticate with an API key as a query param, or a HTTP header value. You can think of this as a simple [Guzzle](https://docs.guzzlephp.org/en/stable/) client.

There is a single **Generic** Credentials Client where you can supply:

- URL
- Query String
- Headers
- HTTP Basic Auth

Once created, you'll be able to call the client in your template to make requests with.

```twig
{# Fetch the data for the `myClient` client, as configured by the `URL` #}
{% set data = craft.consume.fetchData('myClient') %}

{# Fetch the `/account` endpoint, based off the URL in the client settings #}
{% set data = craft.consume.fetchData('myClient', 'GET', 'account') %}
```

## OAuth Client
Similarly, an OAuth Client will provide the same thing - providing you a [Guzzle](https://docs.guzzlephp.org/en/stable/) client that's bootstrapped with all the authentication that goes with OAuth without you having to worry about it.

You can either pick from one of the 80+ natively supported providers, or create your own **Generic** client.

A **Generic** client will require:

- Client ID
- Client Secret
- Scopes (depending on your provider)
- Authorization URL
- Token URL
- API URL

Ensure you provide all these details, then click the **Connect** button to initialize the OAuth handshake to authenticate you with the provider and fetch an access token. This access token will be saved for future requests.

:::tip
If the provider supports refresh access tokens, Consume will automatically refresh an expired access token. You can sit back and relax knowing you'll always have an authenticated client!
:::

Once created, you'll be able to call the client in your template to make requests with.

```twig
{# Fetch the data for the `myClient` client, as configured by the `URL` #}
{% set data = craft.consume.fetchData('myClient') %}

{# Fetch the `/account` endpoint, based off the URL in the client settings #}
{% set data = craft.consume.fetchData('myClient', 'GET', 'account') %}
```
