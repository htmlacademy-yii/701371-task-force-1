<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;

use frontend\models\Task;
use frontend\models\TaskFile;
use frontend\models\Users;
use frontend\models\Reviews;
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

    // NOTE: ...index.php?r=tasks/view&id=2
    public function actionView($id = null): string
    {
        if (empty($id)) {
            $id = 2;
        }

        $task = Task::findOne($id);
        $taskFile = TaskFile::findAll(['task_id' => $id]);

        $idUser = $task->executor->id;
        $users = Users::findOne($idUser);
        $review = Reviews::find()
            ->where(['account_id' => $idUser])
            ->one();

        return $this->render('view',
            compact('task', 'taskFile', 'users', 'review')
        );
    }
}
