<?php

use frontend\assets\TasksAsset;
use frontend\assets\YandexMapAsset;
use frontend\helpers\TaskPermissionHelper;
use frontend\helpers\TaskRespondPermissionHelper;
use frontend\models\Task;
use frontend\models\TaskRespond;
use frontend\models\Users;
use frontend\widgets\ElapsedTimeWidget;
use frontend\widgets\RatingWidget;
use frontend\widgets\TaskActionsButtonsWidget;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\Html;

/**
 * @var Task[] $customerOrders
 * @var Task[] $customerReviews
 * @var Review[] $customerRaiting
 * @var TaskRespond[] $responds
 * @var Users $user
 * @var Task $task
 * @var View $this
 */

$this->title = 'Главная страница';
Yii::$app->formatter->language = 'ru-RU';

TasksAsset::register($this);
YandexMapAsset::register($this);

?>


<main class="page-main">
    <div class="main-container page-container">
        <section class="content-view">
            <div class="content-view__card">
                <div class="content-view__card-wrapper">
                    <div class="content-view__header">
                        <div class="content-view__headline">
                            <h1><?= $task->title; ?></h1>
                            <span>Размещено в категории
                                <a href="#" class="link-regular"><?= $task->category->name; ?></a>
                                <?= ElapsedTimeWidget::widget(['currentTime' => $task->created]); ?> назад
                        </div>
                        <b class="new-task__price new-task__price--clean content-view-price"><?= $task->price; ?><b> ₽</b></b>
                        <div class="new-task__icon new-task__icon--<?= $task->category->css_class; ?> content-view-icon"></div>
                    </div>
                    <div class="content-view__description">
                        <h3 class="content-view__h3">Общее описание</h3>
                        <p>
                            <?= $task->description; ?>
                        </p>
                    </div>
                    <div class="content-view__attach">
                        <h3 class="content-view__h3">Вложения</h3>

                            <?php foreach ($task->taskFiles as $files): ?>
                                <a href="./files/<?= $files->image_path; ?>" download><?= $files->image_path; ?></a>
                            <?php endforeach; ?>

                    </div>
                    <div class="content-view__location">
                        <h3 class="content-view__h3">Расположение</h3>
                        <div class="content-view__location-wrapper">
                            <div class="content-view__map"
                                 style="width: 361px; height: 292px;">

                                <a href="#">
                                    <?= Html::img('@web/img/map.jpg',
                                        [
                                            'alt' => 'Москва, Новый арбат, 23 к. 1',
                                            'style' => 'width: 361px; height: 292px;'
                                        ]
                                    ) ?>
                                </a>
                            </div>

                            <div class="content-view__address">
                                <span class="address__town">

                                    <?= Html::encode($task->address ?? ''); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NOTE: buttons for displaying actions for the task author -->
                <?= TaskActionsButtonsWidget::widget(['task' => $task]); ?>
            </div>

            <?php if (!TaskPermissionHelper::canViewResponseButtons($task, $user)): ?>

                <div class="content-view__feedback">
                <h2>Отклики <span><?= count($task->responds) ?></span></h2>
                <div class="content-view__feedback-wrapper">

                    <?php foreach ($task->responds as $respond): ?>
                        <!--
                        NOTE:
                        if the current user is a performer and he is NOT the
                        author of the current task, then skip it
                        -->
                        <?php if (
                            !$user->isCustomer()
                            && $respond->user_id != Yii::$app->user->identity->getId()
                        ): ?>
                            <?php continue; ?>
                        <?php endif; ?>

                        <div class="content-view__feedback-card">
                            <div class="feedback-card__top">
                                <a href="#">
                                    <?= Html::img("@web/img/{$respond->user->getUserAvatarPath()}",
                                        [
                                            'alt' => 'Аватар заказчика',
                                            'style' => 'width: 43px; height: 44px;'
                                        ]
                                    ) ?>
                                </a>
                                <div class="feedback-card__top--name">

                                    <p><a href="#" class="link-regular"><?= $respond->user->name; ?></a></p>
                                    <?php echo RatingWidget::widget(['currentRaiting' => $respond->user->averageRating]); ?>
                                    <b><?= $respond->user->averageRating; ?></b>

                                </div>
                                <span class="new-task__time"><?= ElapsedTimeWidget::widget(['currentTime' => $respond->datetime]); ?> назад</span>
                            </div>
                            <div class="feedback-card__content">
                                <p><?= $respond->comment; ?></p>
                                <span><?= $respond->price; ?></span>

                            </div>

                            <?php if (TaskRespondPermissionHelper::canViewAllResponds($task, $user)): ?>
                                <?php if ($respond->isNew() || $respond->isApproved()): ?>
                                    <div class="feedback-card__actions">
                                        <a href="<?= Url::to([
                                            'tasks/approved',
                                            'respondId' => $respond->id
                                        ]); ?>"
                                            class="button__small-color response-button button">
                                            Подтвердить
                                        </a>

                                        <a href="<?= Url::to([
                                            'tasks/refuse',
                                            'respondId' => $respond->id
                                        ]); ?>"
                                            class="button__small-color refusal-button button">
                                            Отказать
                                        </a>

                                        <button class="button__chat button"
                                            type="button"></button>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

        </section>
        <section class="connect-desk">
            <div class="connect-desk__profile-mini">
                <div class="profile-mini__wrapper">
                    <h3>Заказчик</h3>
                    <div class="profile-mini__top">
                        <?= Html::img('@web/img/' . $user->getUserAvatarPath(),
                            [
                                'alt' => 'Аватар заказчика',
                                'style' => 'width: 62px; height: 62px;'
                            ]
                        ) ?>
                        <div class="profile-mini__name five-stars__rate">

                            <p><?= $task->owner->name; ?></p>

                            <?php echo RatingWidget::widget(['currentRaiting' => $task->owner->averageRating]); ?>

                            <b><?= round($task->owner->averageRating, 2); ?></b>

                        </div>
                    </div>
                    <p class="info-customer">
                        <span><?= count($task->owner->reviews); ?> отзывов</span>
                        <span class="last-"><?= count($task->owner->tasks); ?> заказов</span>
                    </p>
                    <a href="#" class="link-regular">Смотреть профиль</a>
                </div>
            </div>
            <div id="chat-container">
                <chat class="connect-desk__chat" task="<?= $task->id; ?>"></chat>
            </div>
        </section>
    </div>

    <?= $this->render('//layouts/response', compact(
      'responseForm',
      'task')); ?>

    <?= $this->render('//layouts/cancel', ['taskId' => $task->id]); ?>
</main>
