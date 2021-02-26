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
            /**
             * @note
             * old config:
             * 'class' => 'yii\caching\FileCache',
             *
             * new config for Redis:
             */
            'class' => 'yii\redis\Cache',
        ],

        /**
         * @note
         * including Redis
         */
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
    ],
    'language' => 'ru-RU',
];
