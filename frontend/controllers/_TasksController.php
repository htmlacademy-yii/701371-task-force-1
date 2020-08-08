<?php
namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\Task;

// ?r=tasks/index
class TasksController extends Controller
{
    public function actionIndex()
    {
        // select * from Task
        // Task::find()->where(['status_id' => 1])->all();
        $models = Task::find()->all();
        return $this->render('index', ['models' => $models]);
    }
}
