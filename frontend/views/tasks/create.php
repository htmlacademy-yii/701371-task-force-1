<?php
/**
 * @var $form ActiveForm
 * @var TYPE_NAME $taskForm
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use frontend\assets\DropzoneAsset;

$this->title = 'Создать задание';
Yii::$app->formatter->language = 'ru-RU';

// зарегистрировать конкретно в данной вьюхе
// TODO: доделать дроп зон на обычном div за место input
DropzoneAsset::register($this);
?>

<main class="page-main">
    <div class="main-container page-container">
        <section class="create__task">

            <!-- NOTE: fix style bugs -->
            <div class="create__warnings" style="position: absolute; margin: 130px 0 0 670px;">
            <div class="warning-item warning-item--advice">
              <h2>Правила хорошего описания</h2>
              <h3>Подробности</h3>
              <p>Друзья, не используйте случайный<br>
                контент – ни наш, ни чей-либо еще. Заполняйте свои
                макеты, вайрфреймы, мокапы и прототипы реальным
                содержимым.</p>
              <h3>Файлы</h3>
              <p>Если загружаете фотографии объекта, то убедитесь,
                что всё в фокусе, а фото показывает объект со всех
                ракурсов.</p>
            </div>
            <div class="warning-item warning-item--error">
              <h2>Ошибки заполнения формы</h2>
              <h3>Категория</h3>
              <p>Это поле должно быть выбрано.<br>
                Задание должно принадлежать одной из категорий</p>
            </div>
          </div>

            <h1>Публикация нового задания</h1>
            <div class="create__task-main">

                <?php $form = ActiveForm::begin([
                    'id' => $taskForm->formName(),
                    'options' => [
                        'method' => 'post',
                        'enctype' => 'multipart/form-data',
                        'class' => 'create__task-form form-create',
                    ],

                    'validateOnChange' => true,
                ]); ?>

                    <?= $form->field($taskForm, 'name',
                        [
                            'labelOptions'  => ['style' => 'color: black;'],
                            'options'       => ['class' => 'create__task-form form-create'],
                        ])
                        ->textInput([
                            'tabindex' => 1,
                            'class'         => 'input textarea',
                            'placeholder'   => 'Повесить полку',
                        ])
                        ->hint('Кратко опишите суть работы', [
                            'class' => 'form-create__span',
                        ]); ?>

                    <?= $form->field($taskForm, 'description',
                        [
                            'labelOptions'  => ['style' => 'color: black;'],
                            'options'       => ['class' => 'create__task-form form-create'],
                        ])
                        ->textArea([
                            'tabindex' => 2,
                            'class'         => 'input textarea',
                            'placeholder'   => 'Разместите ваш текст',
                            'rows'          => 7,
                        ])
                        ->hint('Укажите все пожелания и детали, 
                            чтобы исполнителям было проще соориентироваться', [
                                'class' => 'form-create__span',
                        ]); ?>

                    <?= $form->field($taskForm, 'category',
                        [
                            'labelOptions'  => ['style' => 'color: black;'],
                            'options'       => ['class' => 'create__task-form form-create'],
                        ])
                        ->dropDownList($categories, [
                            'tabindex' => 3,
                            'class'         => 'multiple-select input multiple-select-big',
                            'placeholder'   => 'Разместите ваш текст',
                        ])
                        ->hint('Выберите категорию', [
                            'class' => 'form-create__span',
                        ]); ?>

                    <?= $form->field($taskForm, 'files',
                        [
                            'labelOptions'  => ['style' => 'color: black;'],
                            'options'       => ['class' => 'create__task-form form-create'],
                        ])
                        ->fileInput([
                            'tabindex' => 4,
                            'multiple' => true,
                            'class' => 'create__file',
                        ]); ?>

                    <?= $form->field($taskForm, 'address', [
                            'labelOptions'  => ['style' => 'color: black;'],
                            'options'       => ['class' => 'create__task-form form-create'],
                        ])
                        ->input('search', [
                            'tabindex' => 5,
                            'class' => 'input-navigation input-middle input',
                            'placeholder' => 'Санкт-Петербург, Калининский район',
                        ])
                        ->hint('Укажите адрес исполнения, если задание требует присутствия', [
                            'class' => 'form-create__span',
                        ]); ?>

                    <div class="create__price-time">
                        <?= $form->field($taskForm, 'budget', [
                                'labelOptions'  => ['style' => 'color: black;'],
                                'options'       => ['class' => 'create__task-form form-create'],
                            ])
                            ->textarea([
                                'tabindex' => 6,
                                'rows' => 1,
                                'class' => 'input textarea input-money',
                                'placeholder' => '1000',
                                'style' => 'height: 48.4px; margin-right: 0;'
                            ])
                            ->hint('Не заполняйте для оценки исполнителем', [
                                'class' => 'form-create__span',
                            ]); ?>

                        <?= $form->field($taskForm, 'term',
                            [
                                'labelOptions'  => ['style' => 'color: black;'],
                                'options'       => ['class' => 'create__task-form form-create'],
                            ])
                            ->input('date', [
                                'class' => 'input-middle input input-date',
                            ])
                            ->hint('Укажите крайний срок исполнения', [
                                'class' => 'form-create__span',
                            ]);; ?>
                    </div>

                    <?= Html::submitButton('Опубликовать', ['class' => 'button']); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</main>