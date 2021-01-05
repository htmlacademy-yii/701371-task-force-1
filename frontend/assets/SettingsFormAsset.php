<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class SettingsFormAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/dropSettings.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
