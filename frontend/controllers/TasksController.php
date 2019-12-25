<?php
namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\Task;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $models = Task::find()->all();
        return $this->render('index', ['models' => $models]);
    }
}
