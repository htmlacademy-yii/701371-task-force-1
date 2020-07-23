<?php
namespace frontend\controllers;

use DateTime;
use frontend\models\City;
use frontend\models\TaskRespond;
use frontend\models\TaskFile;
use frontend\models\Reviews;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
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
use frontend\models\forms\ResponseForm;
use yii\helpers\Url;


class TasksController extends SecuredController
{
    // TODO: make user roles linked to the users_roles table
    //public function behaviors()
    //{
    //    return [
    //        'createAccess' => [
    //            'class' => AccessControl::class,
    //            'only' => ['create'],
    //            'rules' => [
    //                [
    //                    'allow' => true,
    //                    'roles' => ['@'],
    //                    'matchCallback' => function ($rule, $action) {
    //                        return Yii::$app->response->redirect(['tasks/index']);
    //                    }
    //                ]
    //            ],
    //        ]
    //    ];
    //}

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

        $user = Users::find()
            ->where(['id' => Yii::$app->user->identity->getId()])
            ->one();

        $responseForm = new ResponseForm();

        if ($task === null) {
            throw new NotFoundHttpException('Такого задания не найдено');
        }

        return $this->render('view',
            compact(
                'task',
                'user',
                'responseForm'
            )
        );
    }

    // NOTE: ...index.php?r=tasks/create
    public function actionCreate()
    {
        $taskForm = new NewTaskForm();
        $categories = Category::find()
            ->select('name')
            ->indexBy('id')
            ->column();

        $cities = City::find()
            ->select('title')
            ->indexBy('id')
            ->column();

        // TODO: What is it verbs ?!
        if (Yii::$app->request->getIsPost()) {
            if (
                $taskForm->load(Yii::$app->request->post())
                && $taskForm->validate()
                && $taskForm->createTask()
            ) {

                $taskForm->files = UploadedFile::getInstances($taskForm, 'files');
                $taskForm->upload();
                return $this->redirect(['tasks/index']);
            }
        }

        return $this->render('create', compact(
            'taskForm',
            'categories',
            'cities'));
    }

    public function actionRefuse($respondId)
    {
        $taskRespond = TaskRespond::findOne($respondId);

        if (!$taskRespond) {
            throw new BadRequestHttpException("Запрашиваемого задания не существует");
        }

        if (
            $taskRespond->status_id == $taskRespond->isNew()
            || $taskRespond->status_id == $taskRespond->isApproved()
        ) {
            $taskRespond->status_id = TaskRespond::STATUS_REFUSED;
            $taskRespond->save();

            return $this->redirect(Url::to(['tasks/view', 'id' => $taskRespond->task_id]));
        }
    }

    /**
     * @param $respondId
     * @return \yii\web\Response|null
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     */
    public function actionApproved($respondId)
    {
        $taskRespond = TaskRespond::findOne($respondId);

        if (!$taskRespond) {
            throw new BadRequestHttpException("Запрашиваемого отклика не существует");
        }

        if ($taskRespond->status_id == $taskRespond->isNew()) {
            $taskRespond->status_id = TaskRespond::STATUS_APPROVED;
            $taskRespond->save();

            // TODO: remember for events after chapter 8
            $task = $taskRespond->task;
            $task->executor_id = $taskRespond->user_id;
            $task->status_id = Task::STATUS_WORK;
            $task->save();

            return $this->redirect(Url::to(['tasks/view', 'id' => $taskRespond->task_id]));
        }
    }

    public function actionResponse()
    {
        $response = new ResponseForm();

        if (Yii::$app->request->getIsPost()) {
            if (
                $response->load(Yii::$app->request->post())
                && $response->validate()
                && $response->createResponse()
            ) {
                return $this->redirect(['tasks/index']);
            }
        }
    }

    public function actionCancel()
    {
        $task = Task::findOne(Yii::$app->request->post('taskId'));

        if ($task->isWork()) {
            $task->status_id = Task::STATUS_CANCEL;
            $task->save();
            return $this->redirect(Url::to(['tasks/view', 'id' => $task->id]));
        } else {
            throw new BadRequestHttpException('Задание не находиться в работе');
        }
    }

    public function actionComplete($taskId)
    {
        $task = Task::findOne($taskId);

        if ($task->isWork()) {
            $task->status_id = Task::STATUS_COMPLETED;
            $task->save();
            return $this->redirect(Url::to(['tasks/view', 'id' => $taskId]));
        } else {
            throw new BadRequestHttpException('Не возможно завершить, провалено');
        }
    }
}
