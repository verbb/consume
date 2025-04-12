<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\GitLab as GitLabProvider;

class GitLab extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return GitLabProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'gitLab';

}