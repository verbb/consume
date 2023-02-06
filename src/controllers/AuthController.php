<?php
namespace verbb\consume\controllers;

use verbb\consume\Consume;

use Craft;
use craft\web\Controller;

use yii\web\Response;

use verbb\auth\Auth;
use verbb\auth\helpers\Session;

use Throwable;

class AuthController extends Controller
{
    // Properties
    // =========================================================================

    protected array|int|bool $allowAnonymous = ['connect', 'callback'];


    // Public Methods
    // =========================================================================

    public function beforeAction($action): bool
    {
        // Don't require CSRF validation for callback requests
        if ($action->id === 'callback') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionConnect(): ?Response
    {
        $clientHandle = $this->request->getRequiredParam('client');

        try {
            if (!($client = Consume::$plugin->getClients()->getClientByHandle($clientHandle))) {
                return $this->asFailure(Craft::t('consume', 'Unable to find client “{client}”.', ['client' => $clientHandle]));
            }

            // Keep track of which client instance is for, so we can fetch it in the callback
            Session::set('clientHandle', $clientHandle);

            return Auth::$plugin->getOAuth()->connect('consume', $client);
        } catch (Throwable $e) {
            Consume::error('Unable to authorize connect “{client}”: “{message}” {file}:{line}', [
                'client' => $clientHandle,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return $this->asFailure(Craft::t('consume', 'Unable to authorize connect “{client}”.', ['client' => $clientHandle]));
        }
    }

    public function actionCallback(): ?Response
    {
        // Get both the origin (failure) and redirect (success) URLs
        $origin = Session::get('origin');
        $redirect = Session::get('redirect');

        // Get the client we're current authorizing
        if (!($clientHandle = Session::get('clientHandle'))) {
            Session::setError('consume', Craft::t('consume', 'Unable to find client.'), true);

            return $this->redirect($origin);
        }

        if (!($client = Consume::$plugin->getClients()->getClientByHandle($clientHandle))) {
            Session::setError('consume', Craft::t('consume', 'Unable to find client “{client}”.', ['client' => $clientHandle]), true);

            return $this->redirect($origin);
        }

        try {
            // Fetch the access token from the client and create a Token for us to use
            $token = Auth::$plugin->getOAuth()->callback('consume', $client);

            if (!$token) {
                Session::setError('consume', Craft::t('consume', 'Unable to fetch token.'), true);

                return $this->redirect($origin);
            }

            // Save the token to the Auth plugin, with a reference to this client
            $token->reference = $client->id;
            Auth::$plugin->getTokens()->upsertToken($token);
        } catch (Throwable $e) {
            $error = Craft::t('consume', 'Unable to process callback for “{client}”: “{message}” {file}:{line}', [
                'client' => $clientHandle,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            Consume::error($error);

            // Show the error detail in the CP
            Craft::$app->getSession()->setFlash('consume:callback-error', $error);

            return $this->redirect($origin);
        }

        Session::setNotice('consume', Craft::t('consume', '{provider} connected.', ['provider' => $client->providerName]), true);

        return $this->redirect($redirect);
    }

    public function actionDisconnect(): ?Response
    {
        $clientHandle = $this->request->getRequiredParam('client');

        if (!($client = Consume::$plugin->getClients()->getClientByHandle($clientHandle))) {
            return $this->asFailure(Craft::t('consume', 'Unable to find client “{client}”.', ['client' => $clientHandle]));
        }

        // Delete all tokens for this client
        Auth::$plugin->getTokens()->deleteTokenByOwnerReference('consume', $client->id);

        return $this->asModelSuccess($client, Craft::t('consume', '{provider} disconnected.', ['provider' => $client->providerName]), 'client');
    }

}
