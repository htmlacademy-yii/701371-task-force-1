<?php
namespace classes;

class Task
{
  const STATUS_NEW = 'new';
  const STATUS_ABORT = 'abort';
  const STATUS_PROGRESS = 'progress';
  const STATUS_COMPLETED = 'completed';
  const STATUS_FAILED = 'failed';

  const ACTION_NEW = 'new';
  const ACTION_ABORT = 'abort';
  const ACTION_PROGRESS = 'progress';
  const ACTION_COMPLETE = 'complete';
  const ACTION_FAIL = 'fail';
  const ACTION_CANCEL = 'abort';

  public $action = null;
  public $status = null;

  // **

  public function __construct()
  {
    $this->status = self::STATUS_NEW;
  }

  // **

  public function setUserAction(string $action): void
  {
    $this->action = $action;
  }

  public function getUserAction(): string
  {
    return $this->action . PHP_EOL;
  }

  // **

  public function checkStatus(): void
  {
    if ($this->action === self::ACTION_NEW) {
      $this->status = true;
    }

    if ($this->action === self::ACTION_ABORT) {
      $this->status = false;
    }
  }

  public function beginEvent(): void
  {
    if ($this->action === self::ACTION_NEW && $this->status === true) {
      echo 'status: ' . self::STATUS_NEW . PHP_EOL;
      echo 'status: ' . self::STATUS_PROGRESS . PHP_EOL;

      // TODO: code there...

      echo 'status: ' . self::STATUS_COMPLETED . PHP_EOL;
    } else {
      echo 'status: ' . self::STATUS_ABORT . PHP_EOL;
    }
  }
}