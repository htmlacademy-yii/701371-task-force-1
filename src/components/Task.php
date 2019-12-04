<?php
declare(strict_types=1);

namespace app\components;
use app\components\exception\TaskException;

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

		if ($this->status && !in_array($this->status, $this->getStatuses())) {
			throw new TaskException('Invalid Task::status exception');
		}
	}

	/**/

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

	public function getIdExecutor(): ?int
	{
		return $this->executorId;
	}

	public function getCurrentIdClient(): ?int
	{
		return $this->clientId;
	}

	public function getCurrentStatus(): ?string
	{
		return $this->status;
	}
}
