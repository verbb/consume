<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Eventbrite as EventbriteProvider;

class Eventbrite extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return EventbriteProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'eventbrite';

}