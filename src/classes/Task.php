<?php
namespace classes;

class Task
{
  const STATUS_NEW = 'Новое';
  const STATUS_ABORT = 'Отменено';
  const STATUS_PROGRESS = 'Выполняется';
  const STATUS_COMPLETED = 'Завершено';
  const STATUS_FAILED = 'Провалена';

  const ACTION_NEW = 'new';
  const ACTION_ABORT = 'abort';

  public $userAction = null;
  public $userStatus = null;

  // **

  public function __construct() {}

  // **

  public function setUserAction(string $action): void
  {
    $this->userAction = $action;
  }

  public function getUserAction(): string
  {
    return 'User action: ' . $this->userAction . PHP_EOL;
  }

  // **

  public function checkStatus(): void
  {
    if ($this->userAction === self::ACTION_NEW) {
      $this->userStatus = true;
    }

    if ($this->userAction === self::ACTION_ABORT) {
      $this->userStatus = false;
    }
  }

  public function beginEvent(): void
  {
    if ($this->userAction === self::ACTION_NEW && $this->userStatus === true) {
      echo 'status: ' . self::STATUS_NEW . PHP_EOL;
      echo 'status: ' . self::STATUS_PROGRESS . PHP_EOL;

      // TODO: code there...

      echo 'status: ' . self::STATUS_COMPLETED . PHP_EOL;
    } else {
      echo 'status: ' . self::STATUS_ABORT . PHP_EOL;
    }
  }
}