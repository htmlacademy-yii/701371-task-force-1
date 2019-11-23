<?php
declare(strict_types=1);

namespace config;

abstract class TemplateAction
{
  abstract public static function getTitle(): string;
  abstract public static function getAction(): string;
  abstract public static function rightsVerification($rightsVerification): bool;
}