<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

/**/

use components\Task;
use components\Action;
use components\AvailableActions;

use components\RespondAction;
use components\CancelAction;
use components\CompleteAction;
use components\FailAction;

/**/

$myTask = new Task([
	'idClient' => 5,
	'idExecutor' => 3,
]);

var_dump(AvailableActions::getNextStatus(new CompleteAction));