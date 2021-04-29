<?php

namespace frontend\controllers;

use frontend\models\City;
use frontend\models\forms\SignupForm;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;


/**
 * @note
 * for login & save
 *
 * Class SignupController
 * @package frontend\controllers
 */
class SignupController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['?']
                    ]
                ],

                'denyCallback' => function($rule, $action) {
                    return Yii::$app->response->redirect(['tasks']);
                }
            ]
        ];
    }

    /**
     * @note
     * login & save there
     *
     * @return string|Response
     * @throws Exception
     */
    public function actionIndex(): string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $signupForm = new SignupForm();

        $cities = ArrayHelper::map(
            City::find()
                ->orderBy(['title' => SORT_ASC])
                ->all(),
                'id', 'title'
        );

        if (Yii::$app->request->getIsPost()) {
            $signupForm->load(Yii::$app->request->post());

            if ($signupForm->validate() && ($user = $signupForm->createUser())) {
                Yii::$app->user->login($user);

                return $this->goHome();
            }
        }

        return $this->render('index', compact(
            'signupForm',
            'cities'
        ));
    }
}
