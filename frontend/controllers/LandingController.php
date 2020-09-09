<?php

namespace frontend\controllers;

use frontend\models\Task;
use frontend\models\forms\LoginForm;
use TaskForce\components\Geocoder;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use yii\web\Response;
use Yii;

class LandingController extends Controller
{
    /*
     * NOTE:
     * if a logged-in user opens the main page ( / ), they will always be
     * redirected to view tasks.
     * */
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
                    // NOTE: equivalent $this->goHome();
                    return Yii::$app->response->redirect(['tasks']);
                }
            ]
        ];
    }

    // NOTE: ...index.php?r=landing
    public function actionIndex()
    {
        $this->layout = 'landing';
        $form = new LoginForm();

        // NOTE: for renderAjax in view->landing->index
        $this->view->params['model'] = $form;

        $tasks = Task::find()
            ->orderBy(['created' => SORT_ASC])
            ->limit(4)
            ->all();

        // TODO: fix there - additional action login - 09:19
        if (Yii::$app->request->getIsPost() && Yii::$app->request->isAjax) {
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $user = $form->getUser();
                Yii::$app->user->login($user);
                return $this->redirect(['tasks/index']);
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($form);
            }
        }


        return $this->render('index', compact('tasks'));
    }
}
