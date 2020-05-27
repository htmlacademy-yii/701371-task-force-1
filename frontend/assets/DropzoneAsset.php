<?php


namespace frontend\assets;

use yii\web\AssetBundle;

class DropzoneAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/dropzone.js',
    ];

    // загрузит первым, а потом дропзон
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}