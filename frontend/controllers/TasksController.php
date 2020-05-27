<?php
namespace frontend\controllers;

use DateTime;
use frontend\models\TaskRespond;
use frontend\models\TaskFile;
use frontend\models\Reviews;
use yii\filters\AccessControl;
use yii\web\HttpException;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

use yii\data\Pagination;

use yii\helpers\ArrayHelper;

use frontend\models\Task;
use frontend\models\Category;
use frontend\models\TaskFilter;
use frontend\models\Users;
use frontend\models\forms\NewTaskForm;
use yii\web\UploadedFile;


class TasksController extends SecuredController
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

    // NOTE: ...index.php?r=tasks/view&id=getList2
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

    public function actionCreate()
    {
        $user = Yii::$app->user->identity;
        if ($user->status != Users::ROLE_CLIENT) {
            return $this->redirect(['tasks/index']);
        }

        $taskForm = new NewTaskForm();
        $categories = Category::find()
            ->select('name')
            ->indexBy('id')
            ->column();



        if (Yii::$app->request->getIsPost()) {
            //$taskForm->files = UploadedFile::getInstances($taskForm, 'files');
            //$files = $taskForm->upload();

            //var_dump($files);

            $task = new Task();
            $files = $taskForm->upload();

            if (
                $taskForm->load(Yii::$app->request->post())
                && $taskForm->validate()
                && $taskForm->createTask()
            ) {
                return $this->redirect(['tasks/index']);

                //$task = new Task();
                //$task->executor_id = $user->getId();


            }
        }

        return $this->render('create', compact('taskForm', 'categories'));
    }
}
