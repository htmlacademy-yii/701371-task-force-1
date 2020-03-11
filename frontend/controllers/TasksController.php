<?php
namespace frontend\controllers;

use DateTime;
use frontend\models\TaskRespond;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\HttpException;

use frontend\models\Task;
use frontend\models\TaskFile;
use frontend\models\Reviews;
use frontend\models\Category;
use frontend\models\TaskFilter;

use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

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

    // NOTE: ...index.php?r=tasks/view&id=2
    public function actionView(int $id): string
    {
        $task = Task::find()
            ->where(['id' => $id])
            ->with(['taskFiles', 'owner', 'responds'])
            ->one();

        if ($task === null) {
            throw new NotFoundHttpException('Такого задания не найдено');
        }

        return $this->render('view',
            compact('task')
        );
    }
}
