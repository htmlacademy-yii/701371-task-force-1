<?php
declare(strict_types=1);

namespace components;

class CompleteAction extends Action
{
  public static function rightsVerification(AvailableActions $availableActions,
  int $userId): bool
  {
    if (AvailableActions::STATUS_COMPLETED === $availableActions->getCurrentStatus()
      && $availableActions->getIdExecutor() === $userId) {
        return true;
    } else {
      return false;
    }
  }

  public static function getTitle(): string
  {
    return 'Завершить задание';
  }
}
