<?php

namespace frontend\controllers;

use frontend\behaviors\UserLastActivityTimestampBehavior;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;


/**
 * @note
 * rules for all others pages, enabled / disabled access to auth/non-auth users
 *
 * Class SecuredController
 * @package frontend\controllers
 */
abstract class SecuredController extends Controller
{
    /**
     * @return array
     */
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
