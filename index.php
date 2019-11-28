<?php
require_once __DIR__ . '/vendor/autoload.php';
use components\Task;
use components\AvailableActions;
use components\NewAction;

$myTask = new Task([
	'idClient' => 5,
	'idExecutor' => 3,
]);

// Я не понимаю как проверить этот класс и что в него нужно передавать
$temp = new NewAction(NewAction::STATUS_NEW, 2);
$test = new AvailableActions;
$test->getNextStatus($temp);