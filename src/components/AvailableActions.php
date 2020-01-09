<?php
declare(strict_types=1);

namespace app\components;

/*1*/

class AvailableActions
{
	const ACTION_RESPOND = 'respond';
	const ACTION_CANCEL = 'cancel';
	const ACTION_COMPLETE = 'completed';
	const ACTION_FAIL = 'fail';

	const RELATIONS_MAP = [
		CancelAction::class => Task::STATUS_CANCELED,
		CompleteAction::class => Task::STATUS_COMPLETED,
		FailAction::class => Task::STATUS_FAILED
	];

	/**/

	public function getActions(): array
	{
		return [
			self::ACTION_RESPOND,
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
