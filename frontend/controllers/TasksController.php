<?php

namespace frontend\controllers;

use Exception;
use frontend\models\Category;
use frontend\models\City;
use frontend\models\Reviews;
use frontend\models\Task;
use frontend\models\TaskRespond;
use frontend\models\TaskFilter;
use frontend\models\Users;
use frontend\models\forms\NewTaskForm;
use frontend\models\forms\ResponseForm;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;


/**
 * @note
 * class for working with task's
 *
 * Class TasksController
 * @package frontend\controllers
 */
class TasksController extends SecuredController
{
    /**
     * @note
     * for rendering tasks
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $taskFilter = new TaskFilter();

        $tasks = Task::find();
        $categories = ArrayHelper::map(
            Category::find()->all(),
            'id',
            'name'
        );

        $taskFilter->load(Yii::$app->request->get());
        $taskFilter->applyFilters($tasks);

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
            'tasks' => $tasks->all(),
            'categories' => $categories,
            'taskFilter' => $taskFilter,

            'pagesPagination' => $pagesPagination,
        ]);
    }

    /**
     * @note
     * for view task
     *
     * original way: ...index.php?r=tasks/view&id=getList2
     *
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        /** @var Task $task */
        $task = Task::find()
            ->where(['id' => $id])
            ->with(['taskFiles', 'owner', 'responds'])
            ->one();

        if ($task === null) {
            throw new NotFoundHttpException('Такого задания не найдено');
        }

        $user = Users::find()
            ->where(['id' => Yii::$app->user->identity->getId()])
            ->one();

        $responseForm = new ResponseForm();
        $responseForm->taskId = $task->id;

        $this->view->registerJsVar('mapCenter', [$task->latitude, $task->longitude]);

        return $this->render('view',
            compact(
                'task',
                'user',
                'responseForm'
            )
        );
    }

    /**
     * @note
     * creating new task
     *
     * @return string|Response
     * @throws Exception
     */
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

    /**
     * @note
     * for refuse task
     *
     * @param int $respondId
     * @return Response|null
     * @throws BadRequestHttpException
     */
    public function actionRefuse(int $respondId): ?Response
    {
        $taskRespond = TaskRespond::findOne($respondId);

        if (!$taskRespond) {
            throw new BadRequestHttpException("Запрашиваемого задания не существует");
        }

        if (
            $taskRespond->status_id != $taskRespond->isNew()
            || $taskRespond->status_id != $taskRespond->isApproved()
        ) {
            throw new BadRequestHttpException("Задание (Refuse) не найдено");
        }

        $taskRespond->status_id = TaskRespond::STATUS_REFUSED;
        $taskRespond->save();

        return $this->redirect(Url::to(['tasks/view', 'id' => $taskRespond->task_id]));
    }

    /**
     * @note
     * for approved task
     *
     * @param int $respondId
     * @return Response|null
     * @throws BadRequestHttpException
     */
    public function actionApproved(int $respondId): ?Response
    {
        $taskRespond = TaskRespond::findOne($respondId);

        if (!$taskRespond) {
            throw new BadRequestHttpException("Запрашиваемого отклика не существует");
        }

        if ($taskRespond->status_id != $taskRespond->isNew()) {
            throw new BadRequestHttpException("Задание (Approved) не найдено");
        }

        $taskRespond->status_id = TaskRespond::STATUS_APPROVED;
        $taskRespond->save();

        $task = $taskRespond->task;
        $task->executor_id = $taskRespond->user_id;
        $task->status_id = Task::STATUS_WORK;
        $task->save();

        return $this->redirect(Url::to(['tasks/view', 'id' => $taskRespond->task_id]));
    }

    /**
     * @note
     * for response task
     *
     * @return Response|null
     */
    public function actionResponse(): ?Response
    {
        $response = new ResponseForm();

        if (Yii::$app->request->getIsPost()) {
            if (
                $response->load(Yii::$app->request->post())
                && $response->validate()
                && $response->createResponse()
            ) {
                return $this->redirect(['tasks/view', 'id' => $response->taskId]);
            }
        }

        return null;
    }

    /**
     * @note
     * for cancel task
     *
     * @return Response|null
     * @throws BadRequestHttpException
     */
    public function actionCancel(): ?Response
    {
        $task = Task::findOne(Yii::$app->request->post('taskId'));

        if ($task->isNew()) {
            $task->status_id = Task::STATUS_CANCEL;
            $task->save();
            return $this->redirect(Url::to(['tasks/view', 'id' => $task->id]));
        } else {
            throw new BadRequestHttpException('Задание не находиться в работе');
        }
    }

    /**
     * @note
     * for abort task
     *
     * @return Response|null
     * @throws BadRequestHttpException
     */
    public function actionAbort(): ?Response
    {
        $task = Task::findOne(Yii::$app->request->post('taskId'));

        if ($task->isWork() || $task->isFailed() || $task->isResponded() || $task->isNew()) {
            $task->status_id = Task::STATUS_CANCEL;
            $task->save();
            return $this->redirect(Url::to(['tasks/view', 'id' => $task->id]));
        } else {
            throw new BadRequestHttpException('Задание не находиться в работе');
        }
    }

    /**
     * @note
     * for complete task
     *
     * @return Response|null
     * @throws BadRequestHttpException
     */
    public function actionComplete(): ?Response
    {
        $taskId = Yii::$app->request->post('taskId');

        $task = Task::findOne($taskId);
        $review = new Reviews();

        if ($task->isWork()) {
            $task->status_id = Task::STATUS_COMPLETED;
            $task->save();

            $review->task_id = $taskId;
            $review->description = Yii::$app->request->post('reviews');
            $review->rating = Yii::$app->request->post('taskRating');
            $review->save();

            return $this->redirect(Url::to(['tasks/view', 'id' => $taskId]));
        } else {
            throw new BadRequestHttpException('Не возможно завершить, провалено');
        }
    }
}
