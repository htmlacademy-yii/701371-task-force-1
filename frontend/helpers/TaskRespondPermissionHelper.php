<?php


namespace frontend\helpers;

use frontend\models\Task;
use frontend\models\Users;
use Yii;


/**
 * Class TaskRespondPermissionHelper
 * @package frontend\helpers
 */
class TaskRespondPermissionHelper
{
    /**
     * @param Task $task
     * @param Users $user
     * @return bool
     */
    public static function canViewAllResponds(Task $task, Users $user): bool
    {
        return
            $task->responds
                && $user->isCustomer()
                && $task->status_id != $task->isWork();
    }
}
