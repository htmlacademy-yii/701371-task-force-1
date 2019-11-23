<?php
declare(strict_types=1);

namespace config;

abstract class Action
{
  abstract public static function getTitle(): string;

  // **

  private static function getClass()
  {
    return __CLASS__;
  }

  public static function getAction(): string
  {
    static::getClass();
  }

  // **

  abstract public static function rightsVerification($rightsVerification): bool;
}