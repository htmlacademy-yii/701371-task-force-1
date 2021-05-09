<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class TasksAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/messenger.js',

        /**
         * @note
         * including Vue.js
         */
        '//unpkg.com/vue@next',
        'js/ratingVue.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
