<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

/**/

use app\components\Task;
use app\components\Action;
use app\components\AvailableActions;

use app\components\import\Csv2SqlConverter;

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
	echo $exception->getMessage();
}

/**/

echo '<br>';
var_dump(AvailableActions::getNextStatus(new FailAction));

$task = new Task;
var_dump($task->getCurrentIdClient());

/**/

try {
	Csv2SqlConverter::parse('data/categories.csv', 'data/sql');
} catch (Throwable $exception) {
	echo $exception->getMessage();
}