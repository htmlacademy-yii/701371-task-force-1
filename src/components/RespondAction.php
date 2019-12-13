<?php
declare(strict_types=1);

namespace app\components;

class RespondAction extends Action
{
	public static function rightsVerification(Task $task, int $userId): bool
	{
		return $task->getCurrentStatus() === Task::STATUS_NEW
			&& $task->getIdExecutor() === $userId;
	}

	public static function getTitle(): string
	{
		return 'Откликнуться';
	}
}
