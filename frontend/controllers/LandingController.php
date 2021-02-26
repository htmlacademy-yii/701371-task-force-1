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


class LandingController extends Controller
{
    /**
     * @note
     * if a logged-in user opens the main page ( / ), they will always be
     * redirected to view tasks
     *
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
    public function actionIndex()
    {
        $this->layout = 'landing';
        $form = new LoginForm();

        /**
         * @note
         * for renderAjax in view->landing->index
         */
        $this->view->params['model'] = $form;

        $tasks = Task::find()
            ->orderBy(['created' => SORT_ASC])
            ->limit(4)
            ->all();

        if (Yii::$app->request->getIsPost() && Yii::$app->request->isAjax) {
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $user = $form->getUser();

                if (Yii::$app->user->login($user)) {
                    $user = Users::findOne(Yii::$app->user->identity->getId());
                    $user->visit = date('Y-m-d h:i:s');
                    $user->save();
                }

                return $this->redirect(['tasks/index']);
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($form);
            }
        }

        return $this->render('index', compact('tasks'));
    }
}
