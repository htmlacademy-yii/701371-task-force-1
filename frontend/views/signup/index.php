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

<?php $this->beginBlock('woman'); ?>
    <div class="clipart-woman">
        <img src="./img/clipart-woman.png" width="238" height="450">
    </div>
    <div class="clipart-message">
        <div class="clipart-message-text">
            <h2>Знаете ли вы, что?</h2>
            <p>После регистрации вам будет доступно более
                двух тысяч заданий из двадцати разных категорий.</p>
            <p>В среднем, наши исполнители зарабатывают
                от 500 рублей в час.</p>
        </div>
    </div>
<?php $this->endBlock(); ?>
