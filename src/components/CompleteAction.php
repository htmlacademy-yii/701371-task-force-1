<?php
declare(strict_types=1);

namespace TaskForce\components;

class CompleteAction extends Action
{
	public static function rightsVerification(\frontend\models\Task $task, int $userId): bool
	{
		return $task->isWork() && $task->owner_id === $userId;
	}

	public static function getTitle(): string
	{
		return 'Завершить задание';
	}
}
