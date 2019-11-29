<?php
declare(strict_types=1);

namespace components;

class StatusAction extends Action
{
  public static function rightsVerification(Task $task, int $userId): bool
  {
    return Task::STATUS_PROGRESS === $task->getCurrentStatus()
      && $task->getIdExecutor() === $userId;
  }

  public static function getTitle(): string
  {
    return 'Задание в работе';
  }
}
