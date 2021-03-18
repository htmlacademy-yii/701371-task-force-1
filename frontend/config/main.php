<?php

//use yii\web\UrlManager;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

//use \yii\web\Request;
//$baseUrl = str_replace('/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',

    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\ApiModule',
        ],
    ],

    'components' => [

        /**
         * @note
         * for minify html, css, js
         */
        'AssetsMinify' => [
            'class' => '\soladiem\autoMinify\AssetsMinify',
        ],

        /**
         * @note
         * including Redis
         *
         * for installing:
         * curl -sS https://getcomposer.org/installer | php
         * php composer.phar require --prefer-dist yiisoft/yii2-redis
         * mv composer.phar /usr/local/bin/composer
         */
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],

        'request' => [
            'csrfParam' => '_csrf-frontend',

//            'baseUrl'=> '',
//            '' => 'site/index',
//            'baseUrl' => $baseUrl,
        ],
        'user' => [
            'identityClass' => 'frontend\models\Users',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        /**
         * @note
         * OAuth 2.0
         * creating application there - https://vk.com/editapp?act=create
         * my link is there - https://vk.com/editapp?id=7745786&section=options
         *
         * for installing:
         * composer require --prefer-dist yiisoft/yii2-authclient "*"
         */
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => 7752136,
                    'clientSecret' => '8nAYERmaTywI262jjG0O',
                    'scope' => 'email',
                ],
            ],
        ],

         'urlManager' => [
             // 'class' => UrlManager::class,

             'enablePrettyUrl' => true,
             'showScriptName' => false,
             // 'enableStrictParsing' => true,
             'rules' => [
                 '/' => 'landing/index',
                 'tasks' => 'tasks/index',
                 'view/<id:\d+>' => 'tasks/view',
                 'mylist' => 'my-list/index',
                 'settings' => 'settings/index',
                 'create' => 'tasks/create',
                 'users' => 'users/index',

                 /**
                  * @note
                  * POST - working only for POST requests,
                  * GET - for get requests
                  */
                 'GET api/messages/<id:\d+>' => 'api/messages/get',
                 'POST api/messages/<id:\d+>' => 'api/messages/create',

                 /*
                 [
                     'class' => UrlManager::class,
                     'controller' => 'api/messages',
                     'pluralize' => true,
                     'extraPatterns' => [
                         'GET {id}' => 'get',
                         'POST {id}' => 'create',
                     ],

                     // '' => 'site/index',
                     // '' => 'frontend/web/index',
                 ]
                 */
             ],
         ],

    ],
    'params' => $params,
];
