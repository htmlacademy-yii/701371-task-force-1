<?php

/**
 * @var $form ActiveForm
 * @var $model LoginForm
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<section class="modal enter-form form-modal" id="enter-form">
    <h2>Вход на сайт</h2>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'enableClientValidation' => true,
            'enableAjaxValidation' => true,
            'validateOnSubmit' => true,
            'options' => [
                'method' => 'post',
            ],
            'fieldConfig' => [
                'template' => '{label}<br>{input}<br>{error}',
                'labelOptions' => ['class' => 'form-modal-description'],
            ],
        ]); ?>
            <?= $form->field($model, 'email')
                ->input('email', [
                    'class' => 'enter-form-email input input-middle',
                    'autofocus' => true
                ]); ?>

            <?= $form->field($model, 'password')
                ->passwordInput(['class' => 'enter-form-email input input-middle']); ?>

            <?= Html::submitButton('Войти', ['class' => 'button']) ?>

            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['site/auth'],
                'popupMode' => false,
            ]) ?>
        <?php ActiveForm::end(); ?>


  <button class="form-modal-close" type="button">Закрыть</button>
</section>
