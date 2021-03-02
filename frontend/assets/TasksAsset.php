<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class TasksAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/messenger.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
