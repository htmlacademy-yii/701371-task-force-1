<?php


namespace frontend\helpers;

use frontend\models\Task;
use frontend\models\Users;
use Yii;

// TODO: is right ?
class TaskRespondPermissionHelper
{
    public static function canViewAllResponds(Task $task, Users $user)
    {
        return
            $task->responds
                && $user->isCustomer()
                && $task->status_id != $task->isWork();
    }
}
