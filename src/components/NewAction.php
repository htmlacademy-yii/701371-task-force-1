<?php
declare(strict_types=1);

namespace components;

class NewAction extends Action
{
  /**
   * НЕ понимаю зачем вообще нужна эта проверка и эти абстрактные классы?
   * Почему не сделать отдельные классы, которые будут решать конкретные
   * задачи, зачем усложняем код ?
   */

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
