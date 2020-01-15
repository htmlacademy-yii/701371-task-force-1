<?php
namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\Task;
use frontend\models\Category;

class TasksController extends Controller
{
    public function actionIndex(): string
    {
        $tasks = Task::find()->all();
        $categoryes = Category::find()->all();

        return $this->render('index', [
            'tasks' => $tasks,
            'categoryes' => $categoryes
        ]);
    }
}
