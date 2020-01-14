<?php
declare(strict_types=1);

namespace app\components;

class CompleteAction extends Action
{
	public static function rightsVerification(Task $task, int $userId): bool
	{
		return $task->getCurrentStatus() === Task::STATUS_PROGRESS
			&& $task->getCurrentIdClient() === $userId;
	}

	public static function getTitle(): string
	{
		return 'Завершить задание';
	}
}
