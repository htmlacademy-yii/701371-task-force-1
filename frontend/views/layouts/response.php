<?php
/**
 * @var $form ActiveForm
 * @var $model LoginForm
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use frontend\models\forms\ResponseForm;

/** @var ResponseForm $responseForm */
?>

<div class="modal fade" tabindex="-1" role="dialog" id="task-response-form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title">Отклик на задание</h2>
      </div>

      <div class="modal-body">
        <?php $form = ActiveForm::begin([
            'action' => ['tasks/response'],
            'options' => [
                'method' => 'post',
            ]
        ]); ?>

            <?= $form->field($responseForm, 'price',
                [
                    'labelOptions'  => ['style' => 'color: black;'],
                    'options'       => ['class' => 'create__task-form form-create'],
                ])
                ->textInput([
                    'tabindex'    => 1,
                    //'name'        => 'response-payment',
                    'class'       => 'response-form-payment input input-middle input-money',
                    'placeholder' => 'Укажите цену в ₽',
                ]); ?>

            <?= $form->field($responseForm, 'comment',
                [
                    'labelOptions'  => ['style' => 'color: black;'],
                    'options'       => ['class' => 'create__task-form form-create'],
                ])
                ->textArea([
                    'tabindex'      => 2,
                    //'name'          => 'response-comment',
                    'class'         => 'input textarea',
                    'placeholder'   => 'Разместите ваш комментарий здесь',
                    'rows'          => 4,
                ]); ?>

          <?= Html::submitButton('Опубликовать', ['class' => 'button modal-button']); ?>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>