<?php
declare(strict_types=1);

namespace TaskForce\components;
use \frontend\models\Task;
use frontend\models\Users;
use frontend\models\UsersRoles;

class RespondAction extends Action
{
	public static function rightsVerification(Task $task, int $userId): bool
	{
	    $user = Users::findOne($userId);
	    if (!$user) {
	        return false;
        }

		return $task->isNew() && $user->role->key_code != UsersRoles::CUSTOMER_KEY_CODE;
	}

	public static function getTitle(): string
	{
		return 'Откликнуться';
	}
}
