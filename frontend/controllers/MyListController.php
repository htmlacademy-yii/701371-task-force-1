<?php

namespace frontend\controllers;

use frontend\models\Task;
use Yii;


/**
 * @note
 * for working with the user's task list
 *
 * Class MyListController
 * @package frontend\controllers
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
        $user = Yii::$app->user;
        $tasks = Task::find()
            ->where([
                'OR',
                'executor_id' => $user->id,
                'owner_id' => $user->id,
            ])
            ->where(['status_id' => $status])
            ->all();

        return $this->render('index', compact(
            'tasks'
        ));
    }
}
