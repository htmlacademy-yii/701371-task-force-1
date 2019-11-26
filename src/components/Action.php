<?php
declare(strict_types=1);

namespace components;

abstract class Action
{
  abstract public static function getTitle(): string;

  // **

  public static function getAction()
  {
    return static::class;
  }

  // **

  abstract public static function rightsVerification(
    AvailableActions $AvailableActions,
    int $userId
  ): bool;
}

// class NewAction extends Action
// {
// }

// class NewActionChild extends NewAction
// {
// }

// class FailAction extends Action
// {
// }

// echo NewAction::getAction();