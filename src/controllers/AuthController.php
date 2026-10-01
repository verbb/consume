<?php
namespace verbb\consume\controllers;

use verbb\consume\Consume;
use verbb\consume\helpers\ExceptionHelper;

use Craft;
use craft\elements\User;
use craft\web\Controller;

use yii\web\Response;

use Throwable;

use verbb\auth\Auth;
use verbb\auth\helpers\Session;

class AuthController extends Controller
{
    // Properties
    // =========================================================================

    protected array|int|bool $allowAnonymous = ['callback'];


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
        $this->requireAdmin(false);
        $this->requirePostRequest();

        $clientHandle = $this->request->getRequiredParam('client');

        try {
            if (!($client = Consume::$plugin->getClients()->getClientByHandle($clientHandle))) {
                return $this->asFailure(Craft::t('consume', 'Unable to find client “{client}”.', ['client' => $clientHandle]));
            }

            $context = [
                'clientHandle' => $clientHandle,
            ];

            if ($this->request->getIsCpRequest()) {
                if ($redirect = $this->request->getValidatedBodyParam('redirect')) {
                    $context['redirect'] = $this->getView()->renderObjectTemplate($redirect, $client);
                }
            }

            return Auth::getInstance()->getOAuth()->connect('consume', $client, $client->id, $context);
        } catch (Throwable $e) {
            Consume::error('Unable to authorize connect “{client}” ({exception}).', [
                'client' => $clientHandle,
                'exception' => ExceptionHelper::getSafeSummary($e),
            ]);

            return $this->asFailure(Craft::t('consume', 'Unable to authorize connect “{client}”.', ['client' => $clientHandle]));
        }
    }

    public function actionCallback(): ?Response
    {
        $oauth = Auth::getInstance()->getOAuth();

        if ($response = $oauth->prepareCallback('consume')) {
            return $response;
        }

        $oauth->claimAuthorizedCallback('consume', fn(User $user): bool => $user->admin);

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
            $token = $oauth->callback('consume', $client, $client->id);

            if (!$token) {
                Session::setError('consume', Craft::t('consume', 'Unable to fetch token.'), true);

                return $this->redirect($origin);
            }

            // Save the token to the Auth plugin, with a reference to this client
            $token->reference = $client->id;
            Auth::getInstance()->getTokens()->upsertToken($token);
        } catch (Throwable $e) {
            $error = Craft::t('consume', 'Unable to process callback for “{client}”.', [
                'client' => $clientHandle,
            ]);

            Consume::error('Unable to process callback for “{client}” ({exception}).', [
                'client' => $clientHandle,
                'exception' => ExceptionHelper::getSafeSummary($e),
            ]);

            Craft::$app->getSession()->setFlash('consume:callback-error', $error);

            return $this->redirect($origin);
        }

        Session::setNotice('consume', Craft::t('consume', '{provider} connected.', ['provider' => $client->providerName]), true);

        return $this->redirect($redirect);
    }

    public function actionDisconnect(): ?Response
    {
        $this->requireAdmin(false);
        $this->requirePostRequest();

        $clientHandle = $this->request->getRequiredParam('client');

        if (!($client = Consume::$plugin->getClients()->getClientByHandle($clientHandle))) {
            return $this->asFailure(Craft::t('consume', 'Unable to find client “{client}”.', ['client' => $clientHandle]));
        }

        // Delete all tokens for this client
        Auth::getInstance()->getTokens()->deleteTokenByOwnerReference('consume', $client->id);

        return $this->asModelSuccess($client, Craft::t('consume', '{provider} disconnected.', ['provider' => $client->providerName]), 'client');
    }

}
