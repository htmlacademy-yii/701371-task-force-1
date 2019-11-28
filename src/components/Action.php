<?php
declare(strict_types=1);

namespace components;

abstract class Action
{
  abstract public static function getTitle(): string;

  public static function getAction(): string
  {
    return static::class;
  }

  abstract public static function rightsVerification(
    AvailableActions $AvailableActions,
    int $userId
  ): bool;
}