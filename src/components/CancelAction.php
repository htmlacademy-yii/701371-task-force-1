<?php
declare(strict_types=1);

namespace app\components;

class CancelAction extends Action
{
  public static function rightsVerification(Task $task, int $userId): bool
  {
    return $task->getCurrentStatus() === Task::STATUS_NEW
      && $task->getCurrentIdClient() === $userId;
  }

  public static function getTitle(): string
  {
    return 'Отменить задание';
  }
}
