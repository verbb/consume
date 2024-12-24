<?php
namespace verbb\consume\console\controllers;

use verbb\consume\Consume;

use Craft;
use craft\helpers\Console;

use yii\console\Controller;
use yii\console\ExitCode;

use verbb\auth\Auth;

/**
 * Manages OAuth tokens.
 */
class TokensController extends Controller
{
    // Properties
    // =========================================================================

    /**
     * @var string|null The Consume client handle.
     */
    public ?string $handle = null;


    // Public Methods
    // =========================================================================

    public function options($actionID): array
    {
        $options = parent::options($actionID);

        if ($actionID === 'refresh') {
            $options[] = 'handle';
        }

        return $options;
    }

    /**
     * Refresh tokens.
     */
    public function actionRefresh(): int
    {
        if (!$this->handle) {
            $this->stderr('You must specify a Consume client.' . PHP_EOL, Console::FG_RED);
            
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $client = Consume::$plugin->getClients()->getClientByHandle($this->handle);

        if (!$client) {
            $this->stderr('Unable to find client for ' . $this->handle . '.' . PHP_EOL, Console::FG_RED);
            
            return ExitCode::UNSPECIFIED_ERROR;
        }

        if (!$client->getOAuthProvider()->refreshToken($client->getToken(), true)) {
            $this->stderr('Unable to refresh token for ' . $this->handle . '.' . PHP_EOL, Console::FG_RED);
            
            return ExitCode::UNSPECIFIED_ERROR;
        }
        
        $this->stdout('Token refreshed.' . PHP_EOL, Console::FG_GREEN);
        
        return ExitCode::OK;
    }
}
