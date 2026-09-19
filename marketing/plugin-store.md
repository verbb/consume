Consume brings authenticated HTTP requests into Craft templates without scattering credentials and connection details through your Twig. Configure reusable clients once, fetch remote data when you need it, and turn common response formats into workable arrays.

Fetching a little external data should not mean rebuilding authentication in every template. Configure a client once, then make the request from Twig while credentials and connection details stay out of the presentation layer.

## Features

- **OAuth clients:** Connect to established providers without rebuilding the authorisation flow.
- **Credential clients:** Keep API keys and other request credentials in a reusable client.
- **Twig HTTP requests:** Fetch remote content with a Guzzle-backed request directly from a template.
- **Response parsing:** Turn JSON, XML, and CSV responses into values Twig can work with.
- **Caching:** Reuse remote responses and avoid unnecessary calls to upstream services.
- **Custom clients:** Register project-specific providers or extend the generic client types.
- **Useful data, fewer requests:** Parse common response formats into values Twig can use and cache the result instead of asking the upstream service the same question on every page load.
