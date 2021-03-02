<?php

namespace frontend\controllers;

use frontend\behaviors\UserLastActivityTimestampBehavior;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;


abstract class SecuredController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],

                'denyCallback' => function($rule, $action) {
                    return Yii::$app->response->redirect(['landing']);
                }
            ],

            /**
             * @note
             * behavior - including
             */
            UserLastActivityTimestampBehavior::class,
        ];
    }
}
