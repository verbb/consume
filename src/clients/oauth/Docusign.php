<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Docusign as DocusignProvider;

class Docusign extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return DocusignProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'docusign';

}