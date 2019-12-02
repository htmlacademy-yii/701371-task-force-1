<?php
declare(strict_types=1);

namespace components;

require_once 'Action.php';
use components\Action;

class RespondAction extends Action
{
  public static function rightsVerification(Task $task, int $userId): bool
  {
    return $task->getCurrentStatus() === Task::STATUS_NEW
      && $task->getCurrentIdClient() === $userId;
  }

  public static function getTitle(): string
  {
    return 'Задание в работе';
  }
}
