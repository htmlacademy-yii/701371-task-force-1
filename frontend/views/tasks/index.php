<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

// NOTE: for pagination
use yii\widgets\LinkPager;

$this->title = 'Главная страница';
Yii::$app->formatter->language = 'ru-RU';
?>

<main class="page-main">
<div class="main-container page-container">
    <section class="new-task">
        <div class="new-task__wrapper">
            <h1>Новые задания</h1>

                <?php
                    /** @var Task[] $tasks */
                    foreach ($tasks as $task):
                ?>
                    <div class="new-task__card">
                        <div class="new-task__title">
                            <a href="#" class="link-regular"><h2><?= $task->title; ?></h2></a>
                            <a  class="new-task__type link-regular" href="#"><p><?= $task->category->name; ?></p></a>
                        </div>
                        <div class="new-task__icon new-task__icon--<?= $task->category->css_class; ?>"></div>
                        <p class="new-task_description">
                            <?= $task->description; ?>
                        </p>
                        <b class="new-task__price new-task__price--translation"><?= $task->price; ?><b> ₽</b></b>
                        <p class="new-task__place"><?= $task->address; ?></p>

                        <?php
                            $currentDate = new DateTime();
                            $createDate = new DateTime($task->created);

                            $interval = $currentDate->diff($createDate);
                            echo (int)$interval->d . ' / ' . $interval->h;
                        ?>

                    </div>
                <?php endforeach; ?>

        </div>
        <div class="new-task__pagination">
            <ul class="new-task__pagination-list">

                <?php /** @var Task[] $pagesPagination */ ?>
                <?= LinkPager::widget(['pagination' => $pagesPagination,
                    'options' => ['class' => 'new-task__pagination-list'],
                    'activePageCssClass'  => 'pagination__item--current',

                    'nextPageLabel'    => '-',
                    'nextPageCssClass' => 'pagination__item',

                    'pageCssClass'      => 'pagination__item',
                    'firstPageCssClass' => 'pagination__item--current',

                    'prevPageLabel'    => '-',
                    'prevPageCssClass' => 'pagination__item',
                ]); ?>

            </ul>
        </div>
    </section>
    <section  class="search-task">
        <div class="search-task__wrapper">
            <form class="search-task__form" name="test" method="post" action="#">
                <fieldset class="search-task__categories">
                    <legend>Категории</legend>

                        <?php /** @var Category[] $categories */ ?>
                        <?php foreach ($categories as $category): ?>
                            <input class="visually-hidden checkbox__input" id="<?= $category->id; ?>" type="checkbox" name="" value="">
                            <label for="<?= $category->id; ?>"><?= $category->name; ?></label>
                        <?php endforeach; ?>

                </fieldset>

                <?php $form = ActiveForm::begin(); ?>
                    <fieldset class="search-task__categories">
                        <legend>Дополнительно</legend>

                        <?php /** @var TaskFilter[] $taskFilter */ ?>
                        <?= Html::activeCheckboxList(
                                $taskFilter,
                                'withoutExecutor',
                                [
                                    'withoutExecutor' => 'Без исполнителя'
                                ],
                                [
                                    'class' => 'visually-hidden checkbox__input',
                                    'id' => '9'
                                ]
                            );
                        ?>

<!--                        <input class="visually-hidden checkbox__input" id="9" type="checkbox" name="" value="">-->
                        <?= Html::activeLabel($taskFilter, 'remoteWork',
                                ['for' => 9]) ?>

                        <input class="visually-hidden checkbox__input" id="10" type="checkbox" name="" value="" checked>
                        <?= Html::activeLabel($taskFilter, 'withoutExecutor',
                                ['for' => 10]) ?>
                    </fieldset>

                    <label class="search-task__name" for="11">Период</label>

                        <?= html::activeDropDownList(
                                $taskFilter,
                                'period',
                                [
                                    'all' => 'За все время',
                                    'day' => 'За день',
                                    'week' => 'За неделю',
                                    'month' => 'За менсяц'
                                ],
                                [
                                    'class' => 'multiple-select input',
                                    'id' => '11'
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
