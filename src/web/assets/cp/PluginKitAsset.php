<?php
namespace verbb\consume\web\assets\cp;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/** Plugin Kit's components for the pages that show one, so the rest of the control panel doesn't load them. */
class PluginKitAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    public function init(): void
    {
        $this->sourcePath = '@verbb/consume/web/assets/cp/dist';

        $this->depends = [
            CpAsset::class,
        ];

        $this->css = [
            'plugin-kit.css',
        ];

        $this->js = [
            'plugin-kit.js',
        ];

        $this->jsOptions = [
            'type' => 'module',
        ];

        parent::init();
    }
}
