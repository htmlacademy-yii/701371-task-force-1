<?php

use frontend\assets\SettingsFormAsset;
use frontend\models\forms\SettingsForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * @var SettingsForm $settingsForm
 * @var ArrayHelper $categoryMap
 */

SettingsFormAsset::register($this);

?>


<main class="page-main">
    <div class="main-container page-container">
        <section class="account__redaction-wrapper">
            <h1>Редактирование настроек профиля</h1>

            <?php $form = ActiveForm::begin([
                'enableClientValidation' => false,
                'options' => [
                    'enctype' => 'multipart/form-data'
                ],
            ]);?>

                <div class="account__redaction-section">
                    <h3 class="div-line">Настройки аккаунта</h3>
                    <div class="account__redaction-section-wrapper">
                        <div class="account__redaction-avatar">

                            <?= Html::img('@web/img/' . Yii::$app->user->identity->avatar->image_path,
                                [
                                    'alt' => 'Аватар пользователя',
                                    'style' => 'width: 142px; height: 142px; border-radius: 4px;'
                                ]
                            ) ?>

                            <?= $form->field($settingsForm, 'avatar', [
                                'template' => '{input}{label}{error}',
                            ])
                                ->fileInput([
                                    'id' => 'upload-avatar',
                                    'class' => ($settingsForm->hasErrors('avatar') ? 'field-danger' : ''),
                                    'multiple' => false,
                                    'style' => 'display: none;',
                                ])
                                ->label(null, ['class' => 'link-regular'])
                                ->error(['class' => 'text-danger']); ?>

                        </div>

                        <!-- ** -->

                        <div class="account__redaction">
                            <div class="account__input account__input--name">
                                <?= $form->field($settingsForm, 'name',
                                    [
                                        'options' => ['class' => 'create__task-form form-create'],
                                    ])
                                    ->textInput([
                                        'tabindex' => 1,
                                        'class' => 'input textarea',
                                        'placeholder' => 'Ваше имя',
                                    ])
                                    ->error(['class' => 'text-danger']); ?>
                            </div>

                            <div class="account__input account__input--email" >
                                <?= $form->field($settingsForm, 'email',
                                    [
                                        'options' => ['class' => 'create__task-form form-create'],
                                    ])
                                    ->textInput([
                                        'tabindex' => 2,
                                        'class' => 'input textarea',
                                        'placeholder' => 'Ваш eMail',
                                    ])
                                    ->error(['class' => 'text-danger']); ?>
                            </div>

                            <div class="account__input account__input--address">
                                <?= $form->field($settingsForm, 'cityId',
                                    [
                                        'options' => ['class' => 'create__task-form form-create',],
                                    ])
                                    ->dropDownList($cities, [
                                        'tabindex'      => 3,
                                        'class'         => 'multiple-select input multiple-select-big',
                                        'placeholder'   => 'Разместите ваш текст',
                                    ]); ?>
                            </div>

                            <div class="account__input account__input--date">
                                <?= $form->field($settingsForm, 'birthday',
                                    [
                                        'options'       => ['class' => 'create__task-form form-create'],
                                    ])
                                    ->input('date', [
                                        'class' => 'input-middle input input-date',
                                    ]); ?>
                            </div>
                            <div class="account__input account__input--info">
                                <?= $form->field($settingsForm, 'description',
                                    [
                                        'options' => ['class' => 'create__task-form form-create'],
                                    ])
                                    ->textArea([
                                        'tabindex' => 2,
                                        'class'         => 'input textarea',
                                        'placeholder'   => 'Разместите ваш текст',
                                        'rows'          => 7,
                                    ]) ?>
                            </div>
                        </div>
                    </div>

                    <!-- ** -->

                    <h3 class="div-line">Выберите свои специализации</h3>
                    <div class="account__redaction-section-wrapper">

                            <?= $form->field($settingsForm, 'specialization')
                                ->checkboxList($categoryMap, [
                                    'item' => function (
                                        $index,
                                        $label,
                                        $name,
                                        $checked,
                                        $id
                                    ) use ($user) {
                                        $checkedParam = $checked ? 'checked' : '';
                                        $result = "<input
                                            class='visually-hidden checkbox__input'
                                            type='checkbox'
                                            name='$name'
                                            id='specializations-$id'
                                            value='$id'
                                            $checkedParam>
                                            
                                            <label for='specializations-$id'>$label</label>";

                                        if (($index + 1) % 2 === 0) {
                                            $result .= '</div><div class="search-task__categories account_checkbox" style="float: left;">';
                                        }

                                        return $result;
                                    },
                                    'tag' => 'div',
                                    'class' => 'search-task__categories account_checkbox',
                                    'style' => 'float: left',
                                ])->label(false);
                            ?>
                    </div>

                    <!-- ** -->

                    <h3 class="div-line">Безопасность</h3>
                    <div class="account__redaction-section-wrapper account__redaction">
                        <div class="account__input">
                            <?= $form->field($settingsForm, 'password',
                                [
                                    'options' => ['class' => 'create__task-form form-create'],
                                ])
                                ->input('password', [
                                    'tabindex' => 3,
                                    'class' => 'input textarea',
                                    'placeholder' => 'Придумайте пароль',
                                    'style' => 'width: 193px; height: 48.4px; margin-right: 0;',
                                ]); ?>
                        </div>

                        <div class="account__input">
                            <?= $form->field($settingsForm, 'passwordCopy',
                                [
                                    'options' => ['class' => 'create__task-form form-create'],
                                ])
                                ->input('password', [
                                    'tabindex' => 5,
                                    'class' => 'input textarea',
                                    'placeholder' => 'Повторите пароль',
                                    'style' => 'width: 193px; height: 48.4px; margin-right: 0;',
                                ]); ?>
                        </div>
                    </div>

                    <!-- ** -->

                    <h3 class="div-line">Фото работ</h3>
                    <div class="account__redaction-section-wrapper account__redaction">

                        <?= $form->field($settingsForm, 'files[]',
                            [
                                'labelOptions'  => ['style' => 'color: black;'],
                                'options'       => ['class' => 'create__task-form form-create'],
                            ])
                            ->fileInput([
                                'tabindex' => 6,
                                'multiple' => true,
                                'class' => 'create__file',
                                'id' => 'test',
                            ])?>

                        <div class="clear" style="width: 100%;"></div>

                        <?php foreach ($user->usersImages as $img): ?>

                            <div style="border: 1px dashed #979797; width: 160px; height: 195px; margin-right: 10px;">
                                <?= Html::img('@web/img/' . $img->image_path,
                                    [
                                        'alt' => 'Аватар пользователя',
                                        'style' => 'width: 142px; height: 142px; border-radius: 4px;'
                                    ]
                                ) ?>

                                <span
                                   class="button__small-color refusal-button button setting-button__link-delete_file"
                                   data-id="<?= $img->id; ?>">
                                  Удалить
                                </span>
                            </div>

                        <?php endforeach; ?>

                    </div>

                    <!-- ** -->

                    <h3 class="div-line">Контакты</h3>
                    <div class="account__redaction-section-wrapper account__redaction">
                        <div class="account__input">

                            <?= $form->field($settingsForm, 'phone',
                                [
                                    'options' => ['class' => 'create__task-form form-create'],
                                ])
                                ->input('tel', [
                                    'tabindex' => 7,
                                    'class' => 'input textarea',
                                    'placeholder' => '8 (555) 187 44 87',
                                    'style' => 'width: 310px; height: 48.4px; margin-right: 0;',
                                ]); ?>

                        </div>
                        <div class="account__input">

                            <?= $form->field($settingsForm, 'skype',
                                [
                                    'options' => ['class' => 'create__task-form form-create'],
                                ])
                                ->textInput([
                                    'tabindex' => 8,
                                    'class' => 'input textarea',
                                    'placeholder' => 'DenisT',
                                    'style' => 'width: 310px; height: 48.4px; margin-right: 0;',
                                ]); ?>

                        </div>
                        <div class="account__input" >

                            <?= $form->field($settingsForm, 'otherMessenger',
                                [
                                    'options' => ['class' => 'create__task-form form-create'],
                                ])
                                ->textInput([
                                    'tabindex' => 9,
                                    'class' => 'input textarea',
                                    'placeholder' => '@DenisT',
                                    'style' => 'width: 310px; height: 48.4px; margin-right: 0;',
                                ]); ?>

                        </div>
                    </div>

                    <!-- ** -->

                    <h3 class="div-line">Настройки сайта</h3>
                    <h4>Уведомления</h4>
                    <div class="account__redaction-section-wrapper account_section--bottom">

                        <?= $form->field($settingsForm, 'notification')
                            ->checkboxList($notificationList, [
                                'item' => function (
                                    $index,
                                    $label,
                                    $name,
                                    $checked,
                                    $id
                                ) use ($user) {

                                    /**
                                     * @note
                                     * for example: I can do this not in the model but here,
                                     * but this is not quite true..
                                     *
                                     * $checked = in_array($id, array_column($user->getNotification, 'category_id')) ? 'checked' : '';
                                     */

                                    $checkedParam = $checked ? 'checked' : '';
                                    $result = "<input
                                            class='visually-hidden checkbox__input'
                                            type='checkbox'
                                            name='$name'
                                            id='notification-$id'
                                            value='$id'
                                            $checkedParam>
                                            
                                            <label for='notification-$id'>$label</label>";

                                    if (($index + 1) % 2 === 0) {
                                        $result .= '</div><div class="search-task__categories account_checkbox" style="float: left;">';
                                    }

                                    return $result;
                                },
                                'tag' => 'div',
                                'class' => 'search-task__categories account_checkbox',
                                'style' => 'float: left',
                            ])->label(false);
                        ?>
                    </div>
                </div>
                <button class="button" type="submit">Сохранить изменения</button>

            <?php ActiveForm::end(); ?>

        </section>
    </div>
</main>
