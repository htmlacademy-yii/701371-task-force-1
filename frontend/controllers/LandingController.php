<?php


namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use frontend\models\Task;
use frontend\models\forms\LoginForm;
use yii\widgets\ActiveForm;
use yii\web\Response;

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
                    return Yii::$app->response->redirect(['tasks']);
                }
                //'denyCallback' => function ($rule, $action) {
                //    $this->goHome();
                //},
            ]
        ];
    }

    // NOTE: ...index.php?r=landing
    public function actionIndex()
    {
        $this->layout = 'landing';

        $form = new LoginForm();
        $this->view->params['model'] = $form;

        $tasks = Task::find()
            ->orderBy(['created' => SORT_ASC])
            ->limit(4)
            ->all();

        // TODO: is it right ?...
        if (Yii::$app->request->getIsPost() && Yii::$app->request->isAjax) {
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $user = $form->getUser();
                Yii::$app->user->login($user);

                //return $this->goHome();
                return $this->redirect(['tasks/index']);
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($form);
            }
        }


        return $this->render('index', compact('tasks'));
    }
}