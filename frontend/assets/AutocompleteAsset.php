<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AutocompleteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/autocomplete.js',
        '//cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@7.2.0/dist/js/autoComplete.min.js',
    ];
    public $css = [
        '//cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@7.2.0/dist/css/autoComplete.min.css',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
        'yii\web\JQueryAsset',
    ];
}
