<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class TaskErrorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/TaskErrorBlock.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
