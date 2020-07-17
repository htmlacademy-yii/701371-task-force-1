<?php

use frontend\widgets\ElapsedTimeWidget;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\TaskFilter;

// NOTE: for pagination
use yii\widgets\LinkPager;

/**
 * @var Category[] $categories
 * @var TaskFilter[] $taskFilter
 * @var Task[] $tasks
 * @var Task[] $pagesPagination
 */

$this->title = 'Главная страница';
Yii::$app->formatter->language = 'ru-RU';
?>

<main class="page-main">
<div class="main-container page-container">
    <section class="new-task">
        <div class="new-task__wrapper">
            <h1>Новые задания</h1>

                <?php foreach ($tasks as $task): ?>
                    <div class="new-task__card">
                        <div class="new-task__title">

                            <a href="<?= Url::to(['tasks/view', 'id' => $task->id]); ?>" class="link-regular">
                                <h2><?= $task->title; ?></h2>
                            </a>
                            <a class="new-task__type link-regular" href="#">
                                <p><?= $task->category->name; ?></p>
                            </a>

                        </div>
                        <div class="new-task__icon new-task__icon--<?= $task->category->css_class; ?>"></div>
                        <p class="new-task_description">
                            <?= $task->description; ?>
                        </p>
                        <b class="new-task__price new-task__price--translation"><?= $task->price; ?><b> ₽</b></b>
                        <p class="new-task__place"><?= $task->address; ?></p>

                        <?= ElapsedTimeWidget::widget(['currentTime' => $task->created]); ?>

                    </div>
                <?php endforeach; ?>

        </div>
        <div class="new-task__pagination">
            <ul class="new-task__pagination-list">

                <?= LinkPager::widget(['pagination' => $pagesPagination,
                    //TODO: basic layout doesn't work?
                    //'options' => ['class' => 'new-task__pagination-list'],
                    //'activePageCssClass'  => 'pagination__item--current',

                    //'nextPageLabel'    => '-',
                    //'nextPageCssClass' => 'pagination__item',

                    //'pageCssClass'      => 'pagination__item',
                    //'firstPageCssClass' => 'pagination__item--current',

                    //'prevPageLabel'    => '-',
                    //'prevPageCssClass' => 'pagination__item',
                ]); ?>

            </ul>
        </div>
    </section>
    <section  class="search-task">
        <div class="search-task__wrapper">
            <form class="search-task__form" name="test" method="post" action="#">
                <fieldset class="search-task__categories">
                    <legend>Категории</legend>

                        <?= Html::activeCheckBoxList(
                            $taskFilter,
                            'categories',
                            $categories,
                            [
                                'class' => '_visually-hidden checkbox__input',
                                'id'    => 'asd',
                                'item'  => function (
                                    $index,
                                    $label,
                                    $name,
                                    $checked,
                                    $value
                                ) {
                                    $isChecked = $checked ? 'checked' : '';

return <<<HTML
                                    <input class="visually-hidden checkbox__input" 
                                        id="{$index}" 
                                        type="checkbox" 
                                        name="{$name}" 
                                        value="{$value}" 
                                        {$isChecked}>
                                      
                                    <label for="{$index}">{$label}</label>
HTML;
                                    }
                                ]
                            ); ?>

                </fieldset>

                <?php $filterForm = ActiveForm::begin(); ?>
                    <fieldset class="search-task__categories">
                        <legend>Дополнительно</legend>

                                <?= $filterForm->field(
                                    $taskFilter,
                                    'remoteWork',
                                    [
                                        'template' => "{input}\n{label}",
                                        'options' => ['tag' => false]
                                    ])->checkbox(
                                        ['class' => 'visually-hidden checkbox__input'],
                                        false
                                    );
                                ?>

                                <?= $filterForm->field(
                                    $taskFilter,
                                    'withoutExecutor',
                                    [
                                        'template' => "{input}\n{label}",
                                        'options' => ['tag' => false]
                                    ])->checkbox(
                                        ['class' => 'visually-hidden checkbox__input'],
                                        false
                                    );
                                ?>

                    </fieldset>

                    <?= $filterForm->field(
                        $taskFilter,
                        'period',
                        [
                            'template'     => "{label}\n{input}",
                            'options'      => ['tag' => false],
                            'labelOptions' => ['class' => 'search-task__name']
                        ])->dropDownList(
                            TaskFilter::TIME_PERIODS_TITLES,
                            [
                                'class' => 'multiple-select input',
                                'options' => [TaskFilter::TIME_PERIOD_WEEK => ['Selected' => true]]
                            ]
                        );
                    ?>

                    <?= Html::activeLabel($taskFilter, 'search',
                            ['class' => 'search-task__name', 'for' => 12]) ?>
                    <?= Html::activeTextInput($taskFilter, 'title',
                        ['class' => 'input-middle input', 'id' => '12']) ?>

                    <?= Html::submitButton('Искать',
                        ['class' => 'button']); ?>

                <?php ActiveForm::end(); ?>

            </form>
        </div>
    </section>
</div>
</main>
