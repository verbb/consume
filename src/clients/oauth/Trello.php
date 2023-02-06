<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Trello as TrelloProvider;

class Trello extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return TrelloProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'trello';

}