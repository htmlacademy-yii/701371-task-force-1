<?php


namespace frontend\helpers;


use frontend\models\Task;
use frontend\models\Users;
use Yii;

class TaskPermissionHelper
{
    public static function canViewResponseButtons(Task $task, Users $user)
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
}
