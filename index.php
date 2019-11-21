<?php
require_once __DIR__ . '/vendor/autoload.php';
use classes\Task;

$myTask = new Task;

$myTask->cancelTask();
$myTask->createTask();