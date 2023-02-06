<?php
namespace verbb\consume\controllers;

use verbb\consume\Consume;
use verbb\consume\models\Settings;

use Craft;
use craft\helpers\UrlHelper;
use craft\web\Controller;

use yii\web\Response;

class PluginController extends Controller
{
    // Public Methods
    // =========================================================================

    public function actionSettings(): Response
    {
        /* @var Settings $settings */
        $settings = Consume::$plugin->getSettings();

        return $this->renderTemplate('consume/settings', [
            'settings' => $settings,
        ]);
    }
}
