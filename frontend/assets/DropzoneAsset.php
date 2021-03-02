<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class DropzoneAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/dropzone.js',

        // FIXME: left it for later, now it is not required
        //'js/drop.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
