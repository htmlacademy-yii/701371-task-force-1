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
    /**
     * @note
     * to display the user's jobs
     *
     * @param int $status
     * @return string
     */
    public function actionIndex(int $status = Task::STATUS_NEW): string
    {
        $user = \Yii::$app->user;
        $tasks = Task::find()
            ->where([
                'OR',
                'executor_id' => $user->id,
                'owner_id' => $user->id,
            ])
            ->where(['status_id' => $status])
            ->all();

        /**
         * @todo
         * помочь сделать активный маркер в зависимости от выбранного раздела
         */

        return $this->render('index', compact(
            'tasks'
        ));
    }
}
