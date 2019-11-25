<?php
declare(strict_types=1);

namespace config;

class CancelAction extends Action
{
  public static function rightsVerification(AvailableActions $availableActions,
  int $userId): bool
  {
    if (AvailableActions::STATUS_CANCELED === $availableActions->getCurrentStatus()
      && $availableActions->getIdExecutor() === $userId) {
        return true;
    } else {
      return false;
    }
  }

  public static function getTitle(): string
  {
    return 'Отменить задание';
  }
}