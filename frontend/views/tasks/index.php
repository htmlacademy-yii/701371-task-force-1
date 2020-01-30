<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var Task[] $tasks */
/** @var Category[] $categories */
/** @var TaskFilter[] $taskFilter */

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
                            <a href="#" class="link-regular"><h2><?= $task->title; ?></h2></a>
                            <a  class="new-task__type link-regular" href="#"><p><?= $task->category->name; ?></p></a>
                        </div>
                        <div class="new-task__icon new-task__icon--<?= $task->category->css_class; ?>"></div>
                        <p class="new-task_description">
                            <?= $task->description; ?>
                        </p>
                        <b class="new-task__price new-task__price--translation"><?= $task->price; ?><b> ₽</b></b>
                        <p class="new-task__place"><?= $task->address; ?></p>
                        <span class="new-task__time">4 часа назад</span>
                    </div>
                <?php endforeach; ?>

        </div>
        <div class="new-task__pagination">
            <ul class="new-task__pagination-list">
                <li class="pagination__item"><a href="#"></a></li>
                <li class="pagination__item pagination__item--current"><a>1</a></li>
                <li class="pagination__item"><a href="#">2</a></li>
                <li class="pagination__item"><a href="#">3</a></li>
                <li class="pagination__item"><a href="#"></a></li>
            </ul>
        </div>
    </section>
    <section  class="search-task">
        <div class="search-task__wrapper">
            <form class="search-task__form" name="test" method="post" action="#">
                <fieldset class="search-task__categories">
                    <legend>Категории</legend>

                        <?php foreach ($categories as $category): ?>
                            <input class="visually-hidden checkbox__input" id="<?= $category->id; ?>" type="checkbox" name="" value="">
                            <label for="<?= $category->id; ?>"><?= $category->name; ?></label>
                        <?php endforeach; ?>

                </fieldset>

                <?php $form = ActiveForm::begin(); ?>
                    <fieldset class="search-task__categories">

<!--                        --><?//= $form->field($taskFilter, 'categories')
//                            ->checkBoxList(ArrayHelper::map(
//                                $categories, 'id', 'name')); ?>

                        <legend>Дополнительно</legend>
<!--                            --><?//= html::activeCheckboxList(); ?>
                        <input class="visually-hidden checkbox__input" id="16" type="checkbox" name="" value="">
                        <label for="16">Без исполнителя </label>
                       <input class="visually-hidden checkbox__input" id="17" type="checkbox" name="" value="" checked>
                        <label for="17">Удаленная работа </label>
                    </fieldset>

                    <label class="search-task__name" for="8">Период</label>
    <!--                    <select class="multiple-select input" id="8"size="1" name="time[]">-->
    <!--                        <option value="day">За день</option>-->
    <!--                        <option selected value="week">За неделю</option>-->
    <!--                        <option value="month">За месяц</option>-->
    <!--                    </select>-->


                        <?= html::activeDropDownList($taskFilter, 'period', [
                                'all' => 'За все время',
                                'day' => 'За день',
                                'week' => 'За неделю',
                                'month' => 'За менсяц'
                            ], [
                                'class' => 'multiple-select input'
                            ]);
                        ?>

                    <label class="search-task__name" for="9">Поиск по названию</label>
                        <?= Html::input('search', 'nameSearch_q', '', ['class' => 'input-middle input', 'id' => '9']) ?>

                    <?= Html::submitButton('Искать', ['class' => 'button']); ?>
                <?php ActiveForm::end(); ?>

            </form>
        </div>
    </section>
</div>
</main>
