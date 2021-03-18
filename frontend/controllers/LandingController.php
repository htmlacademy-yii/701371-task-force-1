<?php

namespace frontend\controllers;

use frontend\models\Task;
use frontend\models\forms\LoginForm;
use frontend\models\Users;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use yii\web\Response;
use Yii;


/**
 * @note
 * for landing page (not auth user)
 *
 * Class LandingController
 * @package frontend\controllers
 */
class LandingController extends Controller
{
    /**
     * @note
     * if a logged-in user opens the main page ( / ), they will always be
     * redirected to view tasks
     *
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
                    /**
                     * @note
                     * equivalent $this->goHome();
                     */
                    return Yii::$app->response->redirect(['tasks']);
                }
            ]
        ];
    }

    /**
     * @note
     * ...index.php?r=landing
     *
     * @return array|string|Response
     */
    public function actionIndex(): string
    {
        $this->layout = 'landing';
        $form = new LoginForm();

        $tasks = Task::find()
            ->orderBy(['created' => SORT_ASC])
            ->limit(4)
            ->all();

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
