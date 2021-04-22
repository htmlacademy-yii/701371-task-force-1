<?php

declare(strict_types=1);

namespace TaskForce\components;

use app\components\exception\TaskException;


/**
 * @note
 * class for working with task
 *
 * Class Task
 * @package TaskForce\components
 */
class Task
{
	const STATUS_NEW = 'new';
	const STATUS_PROGRESS = 'progress';
	const STATUS_CANCELED = 'cancel';
	const STATUS_COMPLETED = 'completed';
	const STATUS_FAILED = 'failed';

	const ROLES_ANONYMUS = 'anonymous';
	const ROLES_REGISTRED = 'registered';

	private string $status = '';
	private int $executorId = 0;
	private int $clientId = 0;
	private string $completed = '';

    /**
     * Task constructor.
     * @param array $data
     * @throws TaskException
     */
	public function __construct(array $data = []) {
		foreach ($data as $key => $value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}

		if ($this->status && !in_array($this->status, $this->getStatuses())) {
			throw new TaskException('Invalid Task::status exception');
		}
	}

    /**
     * @return array
     */
	public function getStatuses(): array
	{
		return [
			self::STATUS_NEW,
			self::STATUS_CANCELED,
			self::STATUS_PROGRESS,
			self::STATUS_COMPLETED,
			self::STATUS_FAILED
		];
	}

    /**
     * @return int|null
     */
	public function getIdExecutor(): ?int
	{
		return $this->executorId;
	}

    /**
     * @return int|null
     */
	public function getCurrentIdClient(): ?int
	{
		return $this->clientId;
	}

    /**
     * @return string|null
     */
	public function getCurrentStatus(): ?string
	{
		return $this->status;
	}
}
