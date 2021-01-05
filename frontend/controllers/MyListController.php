<?php

namespace frontend\controllers;

use frontend\models\Task;
use function GuzzleHttp\Promise\all;

/**
 * For working with the user's task list
 *
 * Class MyListController
 */
class MyListController extends SecuredController
{
    public function actionIndex(int $category = Task::STATUS_NEW): string
    {
        $user = \Yii::$app->user;
        $tasks = Task::find()
            ->where([
                'AND',
                'executor_id' => $user->id,
                'owner_id' => $user->id,
            ])
            ->where(['status_id' => $category])
            ->all();

        /**
         * TODO:
         * 1. проверить вьюху, а именно стр 22 итп
         * 2. проверить контроллер
         * 3. помочь сделать активный маркер в зависимости от выбранного раздела
         */

        return $this->render('index', compact(
            'tasks'
        ));
    }
}