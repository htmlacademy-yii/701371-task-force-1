<?php
declare(strict_types=1);

namespace components;

class CompleteAction extends Action
{
  public static function rightsVerification(Task $task, int $userId): bool
  {
    return Task::STATUS_COMPLETED === $task->getCurrentStatus()
      && $task->getIdExecutor() === $userId;
  }

  public static function getTitle(): string
  {
    return 'Завершить задание';
  }
}
