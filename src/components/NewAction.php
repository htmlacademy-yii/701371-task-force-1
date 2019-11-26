<?php
declare(strict_types=1);

namespace components;

class NewAction extends Action
{
  public static function rightsVerification(Task $task, int $userId): bool
  {
    if (Task::STATUS_NEW === $task->getCurrentStatus()
      && $task->getIdExecutor() === $userId) {
        return true;
    } else {
      return false;
    }
  }

  public static function getTitle(): string
  {
    return 'Добавить задание';
  }
}
