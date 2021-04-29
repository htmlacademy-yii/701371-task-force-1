<?php

use frontend\models\Task;
use TaskForce\components\CancelAction;
use TaskForce\components\CompleteAction;
use TaskForce\components\RespondAction;
use TaskForce\components\FailAction;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var array $actions
 * @var Task $task
 */

?>

<?php
/**
 * @note
 * such entries return either 1 or 0 (true / false)
 * if (isset($actions[RespondAction::class]))
 */
?>

<div class="content-view__action-buttons">
    <?php if (isset($actions[RespondAction::class])): ?>
        <button class="button button__big-color response-button __open-modal"
            type="button"
            data-for="response-form"
            data-toggle="modal"
            data-target="#task-response-form"><?= RespondAction::getTitle(); ?></button>
    <?php endif; ?>

    <?php if (isset($actions[CancelAction::class])): ?>
        <button class="button button__big-color refusal-button"
            type="button"
            data-for="refuse-form"
            data-toggle="modal"
            data-target="#task-refuse-form"><?= CancelAction::getTitle(); ?></button>
    <?php endif; ?>

    <?php if (isset($actions[CompleteAction::class])): ?>
        <?php $form = ActiveForm::begin([
            'action' => ['tasks/complete'],
            'id' => 1,
            'options' => [
                'method' => 'post',
            ]
        ]); ?>

            <p>Оставьте отзыв</p>
            <label>
                <textarea
                    name="reviews"
                    rows="4"
                    cols="45"
                    placeholder="Ваш отзыв...">
                </textarea>
            </label>

            <label>
                <input
                  type="text"
                  name="taskId"
                  class="hidden"
                  value=<?= $task->id; ?> />
            </label>

            <!-- NOTE: голосовалка рейтинга -->
            <div class="container task-actions__rating" id="app">
                <div class="card">
                    <h1>Vue.js рейтинг</h1>

                    <div class="steps">
                        <div class="steps-content">
                            {{ activeStep.text }}
                        </div>

                        <ul class="steps-list">
                            <input
                              type="text"
                              name="taskRating"
                              class="hidden"
                              :value="activeIndex + 1"
                            />

                            <li
                                class="steps-item"
                                v-for="(step, idx) in steps"
                                :class="{
                                  active: idx === activeIndex,
                                  done: idx < activeIndex
                                }"
                            >
                                <span @click="setActive(idx)">{{idx + 1}}</span>
                                {{step.title}}
                            </li>
                        </ul>

                        <div v-if="isActive">
                            <p class="btn primary" @click="nextOfFinish">
                                {{ 'Применить голосование' }}
                            </p>
                        </div>

                        <div v-else>
                            <p class="btn" @click="reset">Переголосовать заного</p>
                            <p> Ваш указанный рейтинг: {{ activeIndex + 1 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- NOTE: end: голосовалка рейтинга -->

        <?= Html::submitButton(CompleteAction::getTitle(), [
              'style' => 'float: right',
              'class' => 'button button__big-color connection-button',
              'name' => 'complete-button']) ?>

        <?php ActiveForm::end(); ?>
    <?php endif; ?>

    <?php if (isset($actions[FailAction::class])): ?>
        <button class="button button__big-color refusal-button"
            type="button"
            data-for="refuse-form"
            data-toggle="modal"
            data-target="#task-refuse-form"><?= FailAction::getTitle(); ?></button>
    <?php endif; ?>
</div>