<?php

declare(strict_types=1);

namespace TaskForce\components;
use frontend\models\Task;


/**
 * Class Action
 * @package TaskForce\components
 */
abstract class Action
{
    /**
     * @return string
     */
	abstract public static function getTitle(): string;

    /**
     * @return string
     */
	public static function getAction(): string
	{
		return static::class;
	}

    /**
     * @param Task $task
     * @param int $userId
     * @return bool
     */
	abstract public static function rightsVerification(
		Task $task,
		int $userId
	): bool;
}