<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'geocoder' => [
            'class' => 'TaskForce\components\Geocoder',
            'apiKey' => 'abd2d308-bf38-48fb-aa1a-2a45797320b7',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'language' => 'ru-RU',
];
