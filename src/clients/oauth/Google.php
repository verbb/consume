<?php
namespace verbb\consume\clients\oauth;

use verbb\consume\base\OAuthClient;

use craft\helpers\App;

use verbb\auth\Auth;
use verbb\auth\providers\Google as GoogleProvider;

class Google extends OAuthClient
{
    // Static Methods
    // =========================================================================

    public static function getOAuthProviderClass(): string
    {
        return GoogleProvider::class;
    }


    // Properties
    // =========================================================================

    public static string $providerHandle = 'google';
    public ?string $proxyRedirect = null;


    // Public Methods
    // =========================================================================

    public function getProxyRedirect(): ?bool
    {
        return App::parseBooleanEnv($this->proxyRedirect);
    }

    public function getRedirectUri(): ?string
    {
        $uri = parent::getRedirectUri();

        // Allow a proxy to our server to forward on the request - just for local dev ease
        if ($this->getProxyRedirect()) {
            return "https://formie.verbb.io?return=$uri";
        }

        return $uri;
    }

}