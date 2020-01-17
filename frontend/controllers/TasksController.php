<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Task;
use frontend\models\Category;
use frontend\models\TaskFilter;

class TasksController extends Controller
{
    public function actionIndex(): string
    {
        $taskFilter = new TaskFilter();

        $tasks = Task::find()->all();
        $categories = Category::find()->all();

        if (Yii::$app->request->getIsPost()) {
            $taskFilter->load(Yii::$app->request->post());
            $tasks = $taskFilter->applyFilters($tasks);
        }


        return $this->render('index', [
            'tasks' => $tasks,
            'categories' => $categories,
            'taskFilter' => $taskFilter,
        ]);
    }
}
