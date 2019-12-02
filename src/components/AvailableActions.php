<?php
declare(strict_types=1);

namespace components;

use components\Task;
// use components\NewAction;
use components\RespondAction;
use components\CancelAction;
use components\CompleteAction;
use components\FailAction;

class AvailableActions
{
  const ACTION_NEW = 'new';
	const ACTION_START = 'start';
	const ACTION_CANCEL = 'cancel';
	const ACTION_COMPLE = 'completed';
  const ACTION_FAIL = 'fail';

  const RELATIONS_MAP = [
		// NewAction::class => Task::STATUS_NEW,
		RespondAction::class => Task::STATUS_PROGRESS,
		CancelAction::class => Task::STATUS_CANCELED,
		CompleteAction::class => Task::STATUS_COMPLETED,
		FailAction::class => Task::STATUS_FAILED
	];

	// protected $actions = [];

	/**/

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
		return self::RELATIONS_MAP[$action::getAction()] ?? null;
	}
}