<?php

use frontend\models\Task;
use frontend\widgets\ElapsedTimeWidget;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$this->title = 'TaskForce - главная страница';

/**
 * @var Task[] $tasks
 */

?>


<div class="landing-bottom-container">
    <h2>Последние задания на сайте</h2>
    <?php foreach ($tasks as $task): ?>
        <div class="landing-task">
            <div class="landing-task-top task-<?= $task->category->css_class; ?>"></div>
            <div class="landing-task-description">
                <h3><a href="<?= Url::to(['tasks/view', 'id' => $task->id]); ?>" class="link-regular"><?= $task->title; ?></a></h3>
                <p><?=StringHelper::truncate($task->description, 70); ?></p>
            </div>
            <div class="landing-task-info">
                <div class="task-info-left">
                    <p><a href="#" class="link-regular"><?= $task->category->name; ?></a></p>
                    <p><?= ElapsedTimeWidget::widget(['timeStamp' => $task->created]); ?> назад</p>
                </div>
                <span><?= $task->price; ?> <b>₽</b></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="landing-bottom-container">
    <a href="<?= Url::to(['signup/index']); ?>"
       class="button red-button">
      смотреть все задания
    </a>
</div>