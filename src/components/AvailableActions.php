<?php
declare(strict_types=1);

namespace components;
use components\Task;

class AvailableActions
{
  const ACTION_NEW = 'new';
	const ACTION_START = 'start';
	const ACTION_CANCEL = 'cancel';
	const ACTION_COMPLE = 'completed';
  const ACTION_FAIL = 'fail';

  protected $actions = [];

  public function getActions(): array
	{
		return [
			self::ACTION_NEW,
			self::ACTION_CANCEL,
			self::ACTION_COMPLE,
			self::ACTION_FAIL
		];
  }

  public static function getNextAction(User $user, Task $task): array
  {
    $actions = [];
    foreach (static::getActions() as $action) {
      if (!class_exists($action)) {
        throw new \Exception('Действие не существует');
      }
      if ($action::rightsVerification($user, $task)) {
        $actions[] = $action;
      }
    }
    return $actions;
  }
}