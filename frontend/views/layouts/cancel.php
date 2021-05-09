<?php

use frontend\models\forms\LoginForm;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var ActiveForm $form
 * @var LoginForm $model
 * @var int $taskId
 */

?>


<div class="modal fade" tabindex="-1" role="dialog" id="task-refuse-form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title">Отказ от задания</h2>
      </div>

      <div class="modal-body">
          <?= Html::beginForm(Yii::$app->urlManager->createUrl('tasks/abort')); ?>

              <p>
                  Вы собираетесь отказаться от выполнения задания.
                  Это действие приведёт к снижению вашего рейтинга.
                  Вы уверены?
              </p>

              <span class="button__form-modal button" data-dismiss="modal">Отмена</span>

              <?= Html::hiddenInput('taskId', $taskId) ?>
              <?= Html::submitButton('Отказаться', ['class' => 'button__form-modal refusal-button button']) ?>
          <?= Html::endForm(); ?>
      </div>
    </div>
  </div>
</div>
