<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use verbb\auth\Auth;
use verbb\auth\providers\Pipedrive as PipedriveProvider;

class Pipedrive extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return PipedriveProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'pipedrive';

}