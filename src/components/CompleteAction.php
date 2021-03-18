<?php

declare(strict_types=1);

namespace TaskForce\components;


/**
 * @note
 * for complete
 *
 * Class CompleteAction
 * @package TaskForce\components
 */
class CompleteAction extends Action
{
    /**
     * @param \frontend\models\Task $task
     * @param int $userId
     * @return bool
     */
	public static function rightsVerification(\frontend\models\Task $task, int $userId): bool
	{
		return $task->isWork() && $task->owner_id === $userId;
	}

    /**
     * @return string
     */
	public static function getTitle(): string
	{
		return 'Завершить задание';
	}
}
