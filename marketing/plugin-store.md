Consume brings authenticated HTTP requests into Craft templates without scattering credentials and connection details through your Twig. Configure reusable clients once, fetch remote data when you need it, and turn common response formats into workable arrays.

## Features

- Connect to established providers without rebuilding the authorisation flow.
- Keep API keys and other request credentials in a reusable client.
- Fetch remote content with a Guzzle-backed request directly from a template.
- Turn JSON, XML, and CSV responses into values Twig can work with.
- Reuse remote responses and avoid unnecessary calls to upstream services.
- Register project-specific providers or extend the generic client types.

## Providers

Consume includes OAuth clients for more than 80 API providers.

- Amazon
- Apple
- Auth0
- AWeber
- Azure
- Basecamp
- Bitbucket
- Box
- Buddy
- Buffer
- Constant Contact
- Deezer
- DeviantArt
- Discord
- Disqus
- DocuSign
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
- LINE
- LinkedIn
- Linode
- Mailchimp
- Mail.ru
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
- Stack Exchange
- Strava
- Stripe
- SugarCRM
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
- VKontakte
- WeChat
- Weibo
- Yahoo
- Yelp
- Zendesk
- Zoho

We also provide a "Generic" OAuth client in case your provider isn't in the list above.
