<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

/**/

use app\components\Task;
use app\components\Action;
use app\components\AvailableActions;

use app\components\import\CsvToSqlConverter;

use app\components\RespondAction;
use app\components\CancelAction;
use app\components\CompleteAction;
use app\components\FailAction;

/**/

try {
	$myTask = new Task([
		'status' => 'foo',
		'executorId' => 3,
		'clientId' => 5,
		'completed' => '2019-12-24'
	]);
} catch (Throwable $exception) {
	error_log($exception->getMessage());
}

/**/

echo PHP_EOL;
var_dump(AvailableActions::getNextStatus(new FailAction));

$task = new Task;
var_dump($task->getCurrentIdClient());

/**/

echo PHP_EOL;
try {
	$import = new CsvToSqlConverter;
	$import->setFileName('categories.csv');
	$import->beginEvent();
} catch (Throwable $exception) {
	error_log($exception->getMessage());
}
// $sql = CsvToSqlConverter::getSqlFromCsv('data/cities.csv', $value_map, 'city');
// CsvToSqlConverter::writeInSqlFile('data/sql/city.sql', $sql);