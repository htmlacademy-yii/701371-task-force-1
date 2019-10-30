<?php
require_once __DIR__ . '/vendor/autoload.php';
use classes\Task;

$test = new Task;
echo $test->getAction();
?>