<?php

declare(strict_types=1);

namespace TaskForce\components;

use frontend\models\{Task, Users};
use frontend\models\UsersRoles;


/**
 * @note
 * for respond
 *
 * Class RespondAction
 * @package TaskForce\components
 */
class RespondAction extends Action
{
    /**
     * @param Task $task
     * @param int $userId
     * @return bool
     */
	public static function rightsVerification(Task $task, int $userId): bool
	{
	    $user = Users::findOne($userId);
	    if (!$user) {
	        return false;
        }

		return $task->isNew() && !$user->isCustomer();
	}

    /**
     * @return string
     */
	public static function getTitle(): string
	{
		return 'Откликнуться';
	}
}
