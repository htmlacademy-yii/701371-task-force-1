<?php
declare(strict_types=1);

namespace config;

class NewAction extends Action
{
  public static function rightsVerification(AvailableActions $availableActions,
  int $userId): bool
  {
    if (AvailableActions::STATUS_NEW === $availableActions->getCurrentStatus()
      && $availableActions->getIdExecutor() === $userId) {
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