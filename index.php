<?php
require_once __DIR__ . '/vendor/autoload.php';
use classes\Task;

$myTask = new Task([
	'idClient' => 5,
	'idExecutor' => 3,
]);