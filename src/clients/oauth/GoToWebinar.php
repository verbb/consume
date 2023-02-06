<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\GotoWebinar as GotoWebinarProvider;

class GoToWebinar extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return GotoWebinarProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'goToWebinar';

}