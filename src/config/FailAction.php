<?php
declare(strict_types=1);

namespace config;

class FailAction extends Action
{
  public static function rightsVerification(AvailableActions $availableActions,
  int $userId): bool
  {
    if (AvailableActions::STATUS_FAILED === $availableActions->getCurrentStatus()
      && $availableActions->getIdExecutor() === $userId) {
        return true;
    } else {
      return false;
    }
  }

  public static function getTitle(): string
  {
    return 'Ой ой, случилось что то ужасное...';
  }
}