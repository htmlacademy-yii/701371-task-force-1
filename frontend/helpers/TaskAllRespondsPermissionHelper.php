<?php

namespace frontend\helpers;

use frontend\models\Task;
use frontend\models\Users;
use Yii;


/**
 * Class TaskAllRespondsPermissionHelper
 * @package frontend\helpers
 */
class TaskAllRespondsPermissionHelper
{
    /**
     * @param Task $task
     * @param Users $user
     * @return bool
     */
    public static function canViewRespondButtons(Task $task, Users $user): bool
    {
        return
            $task->responds
                && $user->isCustomer()
                && $task->status_id != $task->isWork();
    }
}
