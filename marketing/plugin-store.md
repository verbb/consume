Consume brings authenticated HTTP requests into Craft templates without scattering credentials and connection details through your Twig. Configure reusable clients once, fetch remote data when you need it, and turn common response formats into workable arrays.

Fetching a little external data should not mean rebuilding authentication in every template. Configure a client once, then make the request from Twig while credentials and connection details stay out of the presentation layer.

## Features

- Connect to established providers without rebuilding the authorisation flow.
- Keep API keys and other request credentials in a reusable client.
- Fetch remote content with a Guzzle-backed request directly from a template.
- Turn JSON, XML, and CSV responses into values Twig can work with.
- Reuse remote responses and avoid unnecessary calls to upstream services.
- Register project-specific providers or extend the generic client types.

## Supports
Consume supports 80+ popular OAuth-based API providers for you to create clients for.

- Amazon
- Apple
- Auth0
- Aweber
- Azure
- Basecamp
- Bitbucket
- Box
- Buddy
- Buffer
- ConstantContact
- Deezer
- DeviantArt
- Discord
- Disqus
- Docusign
- Dribbble
- Drip
- Dropbox
- Envato
- Etsy
- Eventbrite
- Facebook
- FedEx
- Fitbit
- Foursquare
- FreshBooks
- GitHub
- GitLab
- Google
- GoToWebinar
- Gumroad
- Harvest
- Heroku
- HubSpot
- Imgur
- Infusionsoft
- Instagram
- Jira
- Line
- LinkedIn
- Linode
- Mailchimp
- Mailru
- Marketo
- Mastodon
- Meetup
- Microsoft
- Mollie
- Odnoklassniki
- PayPal
- Pinterest
- Pipedrive
- Reddit
- Salesforce
- Shopify
- Slack
- Snapchat
- SoundCloud
- Spotify
- Square
- StackExchange
- Strava
- Stripe
- Sugarcrm
- TikTok
- Trello
- Trustpilot
- Tumblr
- Twitch
- Twitter
- Uber
- Unsplash
- Vend
- Vimeo
- Vkontakte
- WeChat
- Weibo
- Yahoo
- Yelp
- Zendesk
- Zoho

We also provide a "Generic" OAuth client in case your provider isn't in the list above.
