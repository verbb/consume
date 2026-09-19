/** Seed Consume clients for the canonical feature screenshot. */

use craft\helpers\Db;
use verbb\auth\Auth;
use verbb\auth\models\Token;
use verbb\consume\clients\credentials\Generic as GenericCredentials;
use verbb\consume\clients\oauth\Facebook;
use verbb\consume\clients\oauth\GitHub;
use verbb\consume\clients\oauth\Mailchimp;
use verbb\consume\Consume;

Db::delete('{{%consume_clients}}');
Auth::getInstance()->getTokens()->deleteTokensByOwner('consume');

$definitions = [
    [
        'type' => GenericCredentials::class,
        'name' => 'API credentials',
        'handle' => 'apiCredentials',
        'settings' => ['url' => 'https://api.example.com'],
        'connected' => false,
    ],
    [
        'type' => Mailchimp::class,
        'name' => 'Mailchimp campaigns',
        'handle' => 'mailchimpCampaigns',
        'settings' => ['clientId' => 'screenshot-client', 'clientSecret' => 'screenshot-secret'],
        'connected' => true,
    ],
    [
        'type' => GitHub::class,
        'name' => 'GitHub releases',
        'handle' => 'githubReleases',
        'settings' => ['clientId' => 'screenshot-client', 'clientSecret' => 'screenshot-secret'],
        'connected' => true,
    ],
    [
        'type' => Facebook::class,
        'name' => 'Facebook pages',
        'handle' => 'facebookPages',
        'settings' => ['clientId' => 'screenshot-client', 'clientSecret' => 'screenshot-secret'],
        'connected' => false,
    ],
];

$clients = Consume::$plugin->getClients();
$tokens = Auth::getInstance()->getTokens();

foreach ($definitions as $definition) {
    $connected = $definition['connected'];
    unset($definition['connected']);

    $client = $clients->createClient(array_merge($definition, ['enabled' => true]));
    if (!$clients->saveClient($client, false)) {
        throw new RuntimeException("Unable to save Consume screenshot client {$client->handle}.");
    }

    if ($connected) {
        $token = new Token([
            'ownerHandle' => 'consume',
            'providerType' => get_class($client),
            'tokenType' => Token::TOKEN_TYPE_OAUTH2,
            'reference' => (string)$client->id,
            'accessToken' => 'consume-screenshot-token',
            'expires' => (string)(time() + 86400),
        ]);

        if (!$tokens->saveToken($token, false)) {
            throw new RuntimeException("Unable to save token for Consume screenshot client {$client->handle}.");
        }
    }
}
