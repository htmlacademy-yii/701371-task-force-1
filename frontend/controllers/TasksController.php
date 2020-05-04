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


class TasksController extends SecuredController
{
    //public function behaviors()
    //{
    //    return [
    //        'access' => [
    //            'class' => AccessControl::class,
    //            'rules' => [
    //                [
    //                    'allow' => false,
    //                    'actions' => ['index'],
    //                    'roles' => ['?']
    //                ]
    //            ],
    //
    //            'denyCallback' => function($rule, $action) {
    //                return Yii::$app->response->redirect(['landing']);
    //            }
    //
    //            //'denyCallback' => function ($rule, $action) {
    //            //    throw new NotFoundHttpException('У вас нет доступа к этой странице');
    //            //}
    //        ]
    //    ];
    //}

    /**/

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
