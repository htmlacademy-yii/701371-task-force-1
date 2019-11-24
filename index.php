<?php
require_once __DIR__ . '/vendor/autoload.php';
use config\AvailableActions;

$myTask = new AvailableActions([
	'idClient' => 5,
	'idExecutor' => 3,
]);