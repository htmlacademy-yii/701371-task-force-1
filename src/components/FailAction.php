<?php
declare(strict_types=1);

namespace TaskForce\components;

class FailAction extends Action
{
	public static function rightsVerification(\frontend\models\Task $task, int $userId): bool
	{
		return $task->isWork() && $task->executor_id === $userId;
	}

	public static function getTitle(): string
	{
		return 'Отказаться';
	}
}
