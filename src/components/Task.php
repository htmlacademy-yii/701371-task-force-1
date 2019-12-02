<?php
declare(strict_types=1);

namespace app\components;

class Task
{
	const STATUS_NEW = 'new';
	const STATUS_PROGRESS = 'progress';
	const STATUS_CANCELED = 'cancel';
	const STATUS_COMPLETED = 'completed';
	const STATUS_FAILED = 'failed';

	const ROLES_ANONYMUS = 'anonymous';
	const ROLES_REGISTRED = 'registered';

	private $status;
	private $executorId;
	private $clientId;
	private $completed;

	public function __construct(array $data = []) {
		foreach ($data as $key => $value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	}

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

	public function getIdExecutor(): int
	{
		return $this->executorId;
	}

	public function getCurrentStatus(): string
	{
		return $this->status;
	}

	public function getCurrentIdClient(): string
	{
		return $this->clientId;
	}
}
