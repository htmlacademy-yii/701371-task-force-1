<?php
declare(strict_types=1);

namespace components;

class CancelAction extends Action
{
  public static function rightsVerification(Task $task, int $userId): bool
  {
    return Task::STATUS_CANCELED === $task->getCurrentStatus()
      && $task->getIdExecutor() === $userId;
  }

  public static function getTitle(): string
  {
    return 'Отменить задание';
  }
}
