<?php

declare(strict_types=1);

namespace TaskForce\components;

use \frontend\models\Task;


/**
 * @note
 * for cancel
 *
 * Class CancelAction
 * @package TaskForce\components
 */
class CancelAction extends Action
{
    /**
     * @param Task $task
     * @param int $userId
     * @return bool
     */
	public static function rightsVerification(Task $task, int $userId): bool
	{
		return $task->isNew() && $task->owner_id === $userId;
	}

    /**
     * @return string
     */
	public static function getTitle(): string
	{
		return 'Отменить задание';
	}
}
