<?php


namespace frontend\helpers;

use frontend\models\Task;
use frontend\models\Users;
use Yii;

class TaskAllRespondsPermissionHelper
{
    public static function canViewRespondButtons(Task $task, Users $user)
    {
        return
            $task->responds
                && $user->isCustomer()
                && $task->status_id != $task->isWork();
    }
}
