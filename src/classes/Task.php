<?php
namespace classes;

class Task
{
  const ACTION_NEW = 'new';
  const ACTION_CANCEL = 'cancel';
  const ACTION_COMPLE = 'completed';
  const ACTION_FAIL = 'fail';

  const STATUS_NEW = 'new';
  const STATUS_CANCELED = 'cancel';
  const STATUS_PROGRESS = 'progress';
  const STATUS_COMPLETED = 'completed';
  const STATUS_FAILED = 'failed';

  const ROLES_ANONYMUS = 'anonymous';
  const ROLES_REGISTRED = 'registered';

  public $status = null;
  public $id_executor = null;
  public $id_client = null;
  public $completed = null;

  // **

  public function __construct()
  {
    $this->status = self::STATUS_NEW;
  }

  // **

  public function getNewAction()
  {
    return self::ACTION_NEW;
  }

  public function getCancelAction()
  {
    return self::ACTION_CANCEL;
  }

  public function getCompleteAction()
  {
    return self::ACTION_COMPLE;
  }

  public function getFailAction()
  {
    return self::ACTION_FAIL;
  }

  // **

  public function getNewStatus()
  {
    return self::STATUS_NEW;
  }

  public function getCancelStatus()
  {
    return self::STATUS_CANCELED;
  }

  public function getProgressStatus()
  {
    return self::STATUS_PROGRESS;
  }

  public function getCompleteStatus()
  {
    return self::STATUS_COMPLETED;
  }

  public function getFailStatus()
  {
    return self::STATUS_FAILED;
  }

  // **

  private function checkStatus($action): void
  {
    $this->status = ($action === $this->getNewAction()) ? true : false;
    $this->status = ($action === $this->getCancelAction()) ? false : true;
  }

  private function beginEvent($action): void
  {
    $this->checkStatus($action);

    if ($action === self::ACTION_NEW && $this->status === true) {
      echo 'status: ' . $this->getNewStatus() . PHP_EOL;
      echo 'status: ' . $this->getProgressStatus() . PHP_EOL;

      // TODO: code there...

      echo 'status: ' . $this->getCompleteStatus() . PHP_EOL;
    } else {
      echo 'status: ' . $this->getCancelStatus() . PHP_EOL;
    }
  }

  public function userAction(string $action): void
  {
    echo 'User action: ' . $action . PHP_EOL;

    $this->beginEvent($action);
  }
}