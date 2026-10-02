<?php
namespace verbb\consume\web\assets\cp;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

use verbb\base\web\assets\cp\CpAsset as VerbbCpAsset;

class ConsumeAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    public function init(): void
    {
        $this->sourcePath = '@verbb/consume/web/assets/cp/dist';

        $this->depends = [
            VerbbCpAsset::class,
            CpAsset::class,
        ];

        $this->css = [
            'consume.css',
        ];

        parent::init();
    }
}
