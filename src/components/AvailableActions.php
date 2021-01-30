<?php
declare(strict_types=1);

namespace TaskForce\components;

use frontend\models\Task;
use frontend\models\forms\ResponseForm;
use yii\web\User;

class AvailableActions
{
	const ACTION_RESPOND = 'respond';
	const ACTION_CANCEL = 'cancel';
	const ACTION_COMPLETE = 'completed';
	const ACTION_FAIL = 'fail';
	const ACTIONS = [
        CancelAction::class,
        CompleteAction::class,
        FailAction::class,
        RespondAction::class,
    ];

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
			self::ACTION_COMPLETE,
			self::ACTION_FAIL
		];
    }

	public static function getNextStatus(Action $action): ?string
	{
		return self::RELATIONS_MAP[$action::getAction()] ?? null;
	}

	public static function getAvailableActions(Task $task, User $user): array
    {
        // NOTE: array_filter - remove unnecessary elements from the array
        return array_filter(self::ACTIONS, function($action) use ($task, $user) {
            /*
             * NOTE:
             * 1- i pass the object where this function is located
             * 2 - function name
             * 3 - arguments that I pass inside the function
             * */
            return call_user_func([$action, 'rightsVerification'], $task, $user->id);
        });
    }
}
