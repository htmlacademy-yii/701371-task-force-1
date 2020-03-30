<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use frontend\models\Task;
use frontend\models\Category;
use frontend\models\TaskFilter;
use yii\helpers\ArrayHelper;

class TasksController extends Controller
{
    public function actionIndex(): string
    {
        $taskFilter = new TaskFilter();

        $tasks = Task::find();
        $categories = ArrayHelper::map(
            Category::find()->all(),
            'id',
            'name'
        );

        if (Yii::$app->request->isPost) {
            $taskFilter->load(Yii::$app->request->post());
            $taskFilter->applyFilters($tasks);
        }

        /**/

        $countQuery = clone $tasks;
        $pagesPagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 3
        ]);

        $tasks->offset($pagesPagination->offset)
            ->limit($pagesPagination->limit)
            ->all();

        /**/

        return $this->render('index', [
            'tasks'      => $tasks->all(),
            'categories' => $categories,
            'taskFilter' => $taskFilter,

            'pagesPagination' => $pagesPagination,
        ]);
    }
}
