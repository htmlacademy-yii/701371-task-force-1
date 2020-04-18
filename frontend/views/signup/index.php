<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Регистрация аккаунта';
?>

<section class="registration__user">
    <h1>Регистрация аккаунта</h1>
    <div class="registration-wrapper">
        <?php $form = $filterForm = ActiveForm::begin([
            'options' => [
                'method'    => 'post',
                'class'     => 'registration__user-form form-create',
            ],
        ]); ?>

            <?= '<hr>'; ?>
            <?= $form->field($signupForm, 'email',
                [
                    'labelOptions' => [
                        'style' => 'color: black;'
                    ],
                    'errorOptions' => [
                        'class' => 'form-create__span-error',
                        'style' => 'color: #FF116E;',
                    ]
                ])
                ->textInput([
                    'class'         => 'input textarea',
                    'placeholder'   => 'kumarm@mail.ru',
                    'value'         => '',
                    'style'         => 'width: 360px',
                ])
                ->hint('Введите валидный адрес электронной почты', [
                    'class' => 'form-create__span',
                ])
                ->label('Электронная почта'); ?>

            <?= '<hr>'; ?>
            <?= $form->field($signupForm, 'name',
                    [
                        'labelOptions' => [
                            'style' => 'color: black;',
                        ],
                        'errorOptions' => [
                            'class' => 'form-create__span-error',
                            'style' => 'color: #FF116E;',
                        ]
                    ])
                    ->textInput([
                        'class'         => 'input textarea',
                        'placeholder'   => 'Мамедов Кумар',
                        'value'         => '',
                        'style'         => 'width: 360px',
                    ])
                    ->hint('Введите ваше имя и фамилию', [
                        'class' => 'form-create__span',
                    ])
                    ->label('Ваше имя'); ?>

            <?= '<hr>'; ?>
            <?= $form->field(
                $signupForm,
                'city',
                [
                    'labelOptions' => [
                        'style' => 'color: black;',
                    ],
                    'errorOptions' => [
                        'class' => 'form-create__span-error',
                        'style' => 'color: #FF116E;',
                    ]
                ])
                ->dropDownList($cities, [
                    'class' => 'multiple-select input town-select registration-town',
                    'style' => 'width: 360px',
                ])
                ->hint('Укажите город, чтобы находить подходящие задачи', [
                    'class' => 'form-create__span',
                ]); ?>

            <?= '<hr>'; ?>
            <?= $form->field($signupForm, 'password',
                [
                    'labelOptions' => [
                        'style' => 'color: black;',
                    ],
                    'errorOptions' => [
                        'class' => 'form-create__span-error',
                        'style' => 'color: #FF116E;',
                    ],
                ])
                ->passwordInput([
                    'class'         => 'input textarea',
                    'value'         => '',
                    'style'         => 'width: 360px; border: 1px solid #FF116E;',
                ])
                ->hint('Придумайте и введите свой пароль', [
                    'class' => 'form-create__span',
                ])
                ->label('Пароль'); ?>

            <?= Html::submitButton('Cоздать аккаунт', [
                'class' => 'button button__registration'
            ]); ?>
        <?php ActiveForm::end(); ?>
    </div>
</section>
