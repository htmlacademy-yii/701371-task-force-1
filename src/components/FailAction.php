<?php

declare(strict_types=1);

namespace TaskForce\components;


/**
 * @note
 * for fail
 *
 * Class FailAction
 * @package TaskForce\components
 */
class FailAction extends Action
{
    /**
     * @param \frontend\models\Task $task
     * @param int $userId
     * @return bool
     */
	public static function rightsVerification(\frontend\models\Task $task, int $userId): bool
	{
		return $task->isWork() && $task->executor_id === $userId;
	}

    /**
     * @return string
     */
	public static function getTitle(): string
	{
		return 'Отказаться';
	}
}
