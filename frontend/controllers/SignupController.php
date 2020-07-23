<?php


namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use frontend\models\forms\SignupForm;
use frontend\models\City;
use frontend\models\Users;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SignupController extends Controller
{
    public function behaviors()
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

    /**/

    // NOTE: ...index.php?r=signup
    public function actionIndex()
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

// 15.19