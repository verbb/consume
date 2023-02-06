<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Meetup as MeetupProvider;

class Meetup extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return MeetupProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'meetup';

}