<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Mailru as MailruProvider;

class Mailru extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return MailruProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'mailru';

}