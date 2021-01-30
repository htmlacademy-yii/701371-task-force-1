<?php
declare(strict_types=1);

namespace TaskForce\components;
use \frontend\models\Task;

class CancelAction extends Action
{
	public static function rightsVerification(Task $task, int $userId): bool
	{
		return $task->isNew() && $task->owner_id === $userId;
	}

	public static function getTitle(): string
	{
		return 'Отменить задание';
	}
}
