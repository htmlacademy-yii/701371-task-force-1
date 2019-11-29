<?php
declare(strict_types=1);

namespace components;

class FailAction extends Action
{
  public static function rightsVerification(Task $task, int $userId): bool
  {
    return Task::STATUS_FAILED === $task->getCurrentStatus()
      && $task->getIdExecutor() === $userId;
  }

  public static function getTitle(): string
  {
    return 'Ой ой, случилось что то ужасное...';
  }
}
