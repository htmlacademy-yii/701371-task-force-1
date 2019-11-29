<?php
require_once __DIR__ . '/vendor/autoload.php';
use components\Task;
use components\AvailableActions;
use components\NewAction;

$myTask = new Task([
	'idClient' => 5,
	'idExecutor' => 3,
]);