<?php

use frontend\models\Task;
use TaskForce\components\CancelAction;
use TaskForce\components\CompleteAction;
use TaskForce\components\RespondAction;
use yii\helpers\Url;

/**
 * @var array $actions
 * @var Task $task
 */
?>

<?php
/*
 * NOTE:
 * such entries return either 1 or 0 (true / false)
 * if (isset($actions[RespondAction::class]))
 * */
?>

<div class="content-view__action-buttons">
    <?php if (isset($actions[RespondAction::class])): ?>
        <button class="button button__big-color response-button __open-modal"
            type="button"
            data-for="response-form"
            data-toggle="modal"
            data-target="#task-response-form">Откликнуться</button>
    <?php endif; ?>

    <?php if (isset($actions[CancelAction::class])): ?>
        <button class="button button__big-color refusal-button"
            type="button"
            data-for="refuse-form"
            data-toggle="modal"
            data-target="#task-refuse-form">Отказаться</button>
    <?php endif; ?>

    <?php if (isset($actions[CompleteAction::class])): ?>
        <a href="<?= Url::to([
            'tasks/complete',
            'taskId' => $task->id
        ]); ?>"
           class="button button__big-color connection-button">
                Завершить
        </a>
    <?php endif; ?>
</div>