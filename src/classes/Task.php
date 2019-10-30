<?php
namespace classes;

class Task
{
  private $action = null;
  private $status = null;

  public function __construct()
  {
    $this->setAction('new');
  }

  // **

  public function setAction(string $actionType = 'new')
  {
    $this->action = ($actionType === 'new') ? 'new' : 'abort';
  }

  public function getAction()
  {
    return $this->action;
  }

  // **

  public function setStatus(string $state)
  {
    if ($state !== 'new' || $state !== 'progress' || $state !== 'completed') {
      echo 'error format';
    } else {
      $this->status = $state;
    }
  }

  public function getStatus()
  {
    return $this->status;
  }

  // **

  protected function prepare()
  {
    if ($this->action === 'new' && empty($this->status)) {
      $this->setStatus('new');
    }

    if ($this->action === 'abort' && $this->status === 'new') {
      $this->setStatus(null);
    }
  }


  public function beginEvent()
  {
    $this->prepare();

    if ($this->action === 'new' && $this->status === 'new') {
      $this->setStatus('progress');
      echo $this->getStatus();

      //TODO: others action there....

      $this->setStatus('completed');
      echo $this->getStatus();
    }

    $this->setAction(null);
    $this->setStatus(null);
  }
}
?>