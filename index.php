<?php
require_once __DIR__ . '/vendor/autoload.php';
use classes\Task;

$myTask = new Task;

$myTask->setUserAction('abort');
echo $myTask->getUserAction();
$myTask->checkStatus();
$myTask->beginEvent();

$myTask->setUserAction('new');
echo $myTask->getUserAction();
$myTask->checkStatus();
$myTask->beginEvent();