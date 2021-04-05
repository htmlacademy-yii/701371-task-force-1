<?php

namespace frontend\helpers;

use frontend\models\Task;
use frontend\models\Users;
use phpDocumentor\Reflection\Types\Boolean;
use Yii;


/**
 * @note
 * helper for task
 *
 * Class TaskPermissionHelper
 * @package frontend\helpers
 */
class TaskPermissionHelper
{
    /**
     * @note
     * for access to buttons of the tasks
     *
     * @param Task $task
     * @param Users $user
     * @return bool
     */
    public static function canViewResponseButtons(Task $task, Users $user): bool
    {
        /*
         * NOTE:
         * 1st condition - if the user id is logged in != customer,
         *
         * 2st condition - if the user id is logged in != id of the user who
         * posted the task
         *
         * then we return - true | else - false
         * */
        return
            !$user->isCustomer()
            && !in_array(
                Yii::$app->user->identity->getId(),
                array_column($task->responds, 'user_id')
            );
    }

    /**
     * @note
     * for access to chat of the tasks
     *
     * @param Task $task
     * @return bool
     */
    public static function canUsersSeeChat(Task $task): bool
    {
        return
            Yii::$app->user->identity->getId() === $task->owner_id
            || Yii::$app->user->identity->getId() === $task->executor_id;
    }
}
