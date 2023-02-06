<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Mailchimp as MailchimpProvider;

class Mailchimp extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return MailchimpProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'mailchimp';

}