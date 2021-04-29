<?php

declare(strict_types=1);

namespace TaskForce\components;

use frontend\models\Task;
use yii\web\User;


/**
 * @note
 * for actions status
 *
 * Class AvailableActions
 * @package TaskForce\components
 */
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
		CancelAction::class => Task::STATUS_CANCEL,
		CompleteAction::class => Task::STATUS_COMPLETED,
		FailAction::class => Task::STATUS_FAIL
	];

    /**
     * @return array
     */
	public function getActions(): array
	{
		return [
			self::ACTION_RESPOND,
			self::ACTION_CANCEL,
			self::ACTION_COMPLETE,
			self::ACTION_FAIL
		];
    }

    /**
     * @note
     * check status
     *
     * @param Action $action
     * @return string|null
     */
	public static function getNextStatus(Action $action): ?string
	{
		return self::RELATIONS_MAP[$action::getAction()] ?? null;
	}

    /**
     * @note
     * return available actions
     *
     * @param Task $task
     * @param User $user
     * @return array
     */
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
