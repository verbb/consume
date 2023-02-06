# Fetching Data
The core part of Consume is being able to fetch data from third party APIs or URL endpoints that you supply. Consume takes care of the authentication side of things with OAuth-based clients, HTTP Basic Auth, API Keys, or HTTP Headers - providing you a HTTP client to make requests with. Because both OAuth and Credentials clients are similar, the way to fetch data for either will be exactly the same.

There are several methods to fetch data with. Let's assume you've created an OAuth or Credentials client in Consume's settings, which we'll use in the following examples.

## Fetching Client Data
You can use the `craft.consume.fetchData()` function call to fetch data, providing the handle of the client you want to use.

```twig
{% set data = craft.consume.fetchData('exampleClientHandle') %}

{# Use `dd` (or dump-and-die) purely for debugging to see what data we're getting #}
{% dd data %}
```

The first parameter should be the handle of your client. You can also provide it as an object to add additional Guzzle [Request Options](https://docs.guzzlephp.org/en/stable/request-options.html) and provider settings.

```twig
{% set client = {
    handle: 'exampleClientHandle',
    verify: false,
} %}

{% set data = craft.consume.fetchData(client) %}
```

### Request Options
Additional request parameters can be provided to `fetchData()`, which are:

- The HTTP `method` (`GET`, `POST`, `PUT`, etc)
- The endpoint, relative to the base URL that the client is configured with
- Any Guzzle [Request Options](https://docs.guzzlephp.org/en/stable/request-options.html) like `query`, `json`, etc.

```twig
{% set data = craft.consume.fetchData('exampleClientHandle', 'GET', 'account', {
    query: {
        limit: '5',
    },
}) %}
```

Here, we're triggering a `GET` request to the `/account` endpoint (relative to the full URL defined in your `exampleClientHandle` client) and passing in a query string to limit (`?limit=5`).

### Twig Function
You can use the `consume()` Twig function to fetch data, which is exactly the same as the above, just a shorthand version.

```twig
{% set data = consume('exampleClientHandle', 'GET', 'me') %}
```

## On-Demand Guzzle Client
You can also use Consume without defining any client in the settings. This allows you to use a Guzzle client directly in your Twig templates. Note that you won't be able to use OAuth-based APIs through this method.

For example, we might want to fetch data from an API manually.

```twig
{% set client = {
    base_uri: 'https://api.my-provider.com/v3/',
    headers: {
        'api-key': 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    },
} %}

{% set data = consume(client, 'GET', 'account') %}
```

Or, we might want to fetch some content from a URL

```twig
{% set client = {
    base_uri: 'https://my-site.test/docs/example.json',
    verify: false,
} %}

{% set data = craft.consume.fetchData(client, 'GET') %}
```

Don't forget that the first parameter of these function can be any of the [Guzzle Client](https://docs.guzzlephp.org/en/stable/quickstart.html#creating-a-client) options, along with the same method signature for a [Request](https://docs.guzzlephp.org/en/stable/request-options.html).

## Data Types
Your endpoint might not return JSON, which is traditionally the common data type returned from APIs. Consume will support you enforcing JSON, XML, CSV or HTML (raw data) on the data returned with fetching. For each data type, Consume will convert the content to an array for you to iterate over in your Twig templates.

### XML
For example, let's say you want to fetch the following XML content:

```xml
<catalog>
   <book id="bk101">
      <author>Gambardella, Matthew</author>
      <title>XML Developer's Guide</title>
   </book>
   <book id="bk102">
      <author>Ralls, Kim</author>
      <title alt="A Fantasy Story">Midnight Rain</title>
   </book>
</catalog>
```

We fetch our data with our client, enforcing the `format` to be `xml`. 

```twig
{% set client = {
    format: 'xml',
    base_uri: 'https://my-site.test/docs/example.xml',
} %}

{% set data = consume(client) %}
```

The result would look like:

```php
[
    'book' => [
        0 => [
            '@id' => 'bk101'
            'author' => 'Gambardella, Matthew'
            'title' => 'XML Developer\'s Guide'
        ]
        1 => [
            '@id' => 'bk102'
            'author' => 'Ralls, Kim'
            'title' => [
                '@alt' => 'A Fantasy Story'
                '#' => 'Ralls, Kim'
            ]
        ]
    ]
]
```

We're using a on-demand Guzzle client, but using a Generic Credentials client with the URL set would also work just the same. However, you'll need to use the object syntax for the client, as Consume will assume the response is JSON unless you instruct differently.

```twig
{% set client = {
    format: 'xml',
    handle: 'exampleClientHandle',
} %}

{% set data = craft.consume.fetchData(client) %}
```

### CSV
Similarly, for a CSV file:

```csv
First Name,Last Name,Address,City,State,Zip
John,Doe,120 jefferson st.,Riverside, NJ, 08075
Jack,McGinnis,220 hobo Av.,Phila, PA,09119
```

```twig
{% set client = {
    format: 'csv',
    base_uri: 'https://my-site.test/docs/example.csv',
} %}

{% set data = consume(client) %}
```

```php
[
    0 => [
        'First Name' => 'John'
        'Last Name' => 'Doe'
        'Address' => '120 jefferson st.'
        'City' => 'Riverside'
        'State' => ' NJ'
        'Zip' => ' 08075'
    ]
    1 => [
        'First Name' => 'Jack'
        'Last Name' => 'McGinnis'
        'Address' => '220 hobo Av.'
        'City' => 'Phila'
        'State' => ' PA'
        'Zip' => '09119'
    ]
]
```

### HTML or Raw
If your endpoint returns HTML, or you'd otherwise like to fetch the "raw" response, you can pass in either `html` or `raw`.

```twig
{% set client = {
    format: 'raw',
    base_uri: 'https://my-site.test/docs/example.txt',
} %}

{% set data = consume(client) %}
```
