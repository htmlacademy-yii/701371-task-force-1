<?php

use frontend\models\Users;
use frontend\models\UsersFilter;
use frontend\widgets\ElapsedTimeWidget;
use frontend\widgets\RatingWidget;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/**
 * @var Users $user
 * @var ActiveDataProvider $dataProvider
 * @var UsersFilter $userFilter
 * @var ArrayHelper $categories
 */

?>


<main class="page-main">
    <div class="main-container page-container">
        <section class="user__search">
            <div class="user__search-link">
                <p>Сортировать по:</p>
                <ul class="user__search-list">
                    <li class="user__search-item user__search-item--current">
                        <a href="#" class="link-regular">Рейтингу</a>
                    </li>
                    <li class="user__search-item">
                        <a href="#" class="link-regular">Числу заказов</a>
                    </li>
                    <li class="user__search-item">
                        <a href="#" class="link-regular">Популярности</a>
                    </li>
                </ul>
            </div>

            <?php foreach ($dataProvider->getModels() as $user): ?>

                <div class="content-view__feedback-card user__search-wrapper">
                    <div class="feedback-card__top">
                        <div class="user__search-icon">
                            <a href="#">
                                <?= Html::img('@web/img/' . $user->getUserAvatarPath(),
                                    [
                                        'alt' => 'Аватар пользователя',
                                        'style' => 'width: 65px; height: 65px; border-radius: 4px;'
                                    ]
                                ) ?>
                            </a>
                            <span><?= count($user->tasks); ?> заданий</span>
                            <span><?= count($user->reviews); ?> отзывов</span>
                        </div>
                        <div class="feedback-card__top--name user__search-card">
                            <p class="link-name">
                                <a href="<?= Url::to(['users/view', 'id' => $user->id]); ?>" class="link-regular">
                                    <?= $user->name; ?>
                                </a>
                            </p>

                            <?php echo RatingWidget::widget(['currentRating' => $user->averageRating]); ?>
                            <b><?= $user->averageRating; ?></b>

                            <p class="user__search-content">
                                <?= $user->about; ?>
                            </p>
                        </div>
                        <span class="new-task__time">Был на сайте <?= ElapsedTimeWidget::widget(['timeStamp' => $user->visit]); ?> назад</span>
                    </div>
                    <div class="link-specialization user__search-link--bottom">

                        <?php foreach ($user->specializationsList as $specialization): ?>

                            <!--
                            NOTE:
                            pass into the model UserFilter property categories->id of current category
                            which we will then go to
                            -->
                            <a href="?UsersFilter[categories]=<?= $specialization->category->id; ?>" class="link-regular"><?= $specialization->category->name; ?></a>
                        <?php endforeach; ?>

                    </div>
                </div>

            <?php endforeach; ?>


            <ul class="new-task__pagination-list">
                <?= LinkPager::widget(['pagination' => $dataProvider->pagination]); ?>
            </ul>

        </section>

        <section  class="search-task">
            <div class="search-task__wrapper">
                <form class="search-task__form" name="users" method="get" action="#">
                    <fieldset class="search-task__categories">
                    <legend>Категории</legend>

                        <?= Html::activeCheckBoxList(
                            $userFilter,
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
                                          id="$index" 
                                          type="checkbox" 
                                          name="$name" 
                                          value="$value" 
                                          $isChecked>
                                        
                                      <label for="$index">$label</label>
HTML;
                              }
                          ]
                      ); ?>

                    </fieldset>

                    <?php $filterForm = ActiveForm::begin(); ?>

                        <fieldset class="search-task__categories">
                            <legend>Дополнительно</legend>
                            <?= $filterForm->field(
                                $userFilter,
                                'isFree',
                                [
                                    'template' => "{input}\n{label}",
                                    'options' => ['tag' => false]
                                ])->checkbox(
                                    ['class' => 'visually-hidden checkbox__input'],
                                    false
                            );
                            ?>

                            <?= $filterForm->field(
                                $userFilter,
                                'isOnline',
                                [
                                    'template' => "{input}\n{label}",
                                    'options' => ['tag' => false]
                                ])->checkbox(
                                    ['class' => 'visually-hidden checkbox__input'],
                                    false
                                );
                            ?>

                            <?= $filterForm->field(
                                $userFilter,
                                'haveReview',
                                [
                                    'template' => "{input}\n{label}",
                                    'options' => ['tag' => false]
                                ])->checkbox(
                                ['class' => 'visually-hidden checkbox__input'],
                                false
                            );
                            ?>
                        </fieldset>

                        <?= Html::activeLabel($userFilter, 'search',
                            ['class' => 'search-task__name', 'for' => 12]) ?>
                        <?= Html::activeTextInput($userFilter, 'userName',
                            ['class' => 'input-middle input', 'id' => '12']) ?>

                        <?= Html::submitButton('Искать',
                            ['class' => 'button']); ?>

                    <?php ActiveForm::end(); ?>
                </form>
            </div>
        </section>
    </div>
</main>
