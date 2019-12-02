<?php
declare(strict_types=1);

namespace components;

require_once 'Action.php';
use components\Action;

class CompleteAction extends Action
{
  public static function rightsVerification(Task $task, int $userId): bool
  {
    return $task->getCurrentStatus() === Task::STATUS_COMPLETED
      && $task->getCurrentIdClient() === $userId;
  }

  public static function getTitle(): string
  {
    return 'Завершить задание';
  }
}
