# Cache
By default, data fetched from providers is cached for performance for 1 hour. You can control this via the `enableCache` and `cacheDuration` plugin settings.

You may wish to disable Consume's automatic caching to use your own `{% cache %}` Twig tag to control caching at the template level.

```
{% cache using key 'my-data' for 1 day %}
    {% set data = craft.consume.fetchData('myClient') %}

    {% for item in data %}
        {# ... #}
    {% endfor %}
{% endcache %}
```