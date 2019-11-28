<?php
declare(strict_types=1);

namespace components;
use components;

class AvailableActions
{
  const ACTION_NEW = 'new';
	const ACTION_START = 'start';
	const ACTION_CANCEL = 'cancel';
	const ACTION_COMPLE = 'completed';
  const ACTION_FAIL = 'fail';

  /**
   * я не понимаю как это будет работать
   * понимаю если будет так:
   * Task::STATUS_NEW => self::ACTION_NEW, ...
   * а в текущем виде как мы сделали, ну не понимаю.
   */
  const RELATIONS_MAP = [
		self::ACTION_NEW => Task::STATUS_NEW,
		self::ACTION_START => Task::STATUS_PROGRESS,
		self::ACTION_CANCEL => Task::STATUS_CANCELED,
		self::ACTION_COMPLE => Task::STATUS_COMPLETED,
		self::ACTION_FAIL => Task::STATUS_FAILED
	];

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

  public static function getNextStatus(Action $action): ?string
  {
    return self::RELATIONS_MAP[Action::class] ?? null;
  }

  // public static function getNextStatus(User $user, Task $task): array
  // {
  //   $actions = [];

  //   foreach (self::getActions() as $action) {
  //     if (!in_array($action)) {
  //       throw new \Exception('Действие не существует');
  //     }
  //     if ($action::rightsVerification($user, $task)) {
  //       $actions[] = $action;
  //     }
  //   }
  //   return $actions;
  // }
}