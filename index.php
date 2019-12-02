<?php
declare(strict_types=1);
// require_once __DIR__ . '/vendor/autoload.php';

require_once './src/components/Task.php';
require_once './src/components/Action.php';
require_once './src/components/AvailableActions.php';

// require_once './src/components/NewAction.php';
require_once './src/components/RespondAction.php';
require_once './src/components/CancelAction.php';
require_once './src/components/CompleteAction.php';
require_once './src/components/FailAction.php';

/**/

use components\Task;
use components\Action;
use components\AvailableActions;

// use components\NewAction;
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