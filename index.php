<?php
require_once __DIR__ . '/vendor/autoload.php';
use classes\Task;

$myTask = new Task;

$myTask->setUserAction('abort');
echo 'User action: ' . $myTask->getUserAction();
$myTask->beginEvent();

$myTask->setUserAction('new');
echo 'User action: ' . $myTask->getUserAction();
$myTask->beginEvent();