<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Jira as JiraProvider;

class Jira extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return JiraProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'jira';

}