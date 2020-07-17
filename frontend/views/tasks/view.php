
<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use frontend\widgets\RatingWidget;
use frontend\widgets\ElapsedTimeWidget;
use frontend\models\Users;
use frontend\helpers\TaskPermissionHelper;
use frontend\models\Task;
use frontend\models\TaskRespond;
use yii\helpers\Url;
use frontend\widgets\TaskActionsButtonsWidget;

// NOTE: to connect a view to another view
use yii\web\View;

// NOTE: for pagination
use yii\widgets\LinkPager;

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
                                <a href="./files/<?= $task->id; ?>/<?= $files->image_path; ?>" download><?= $files->image_path; ?></a>
                            <?php endforeach; ?>

                    </div>
                    <div class="content-view__location">
                        <h3 class="content-view__h3">Расположение</h3>
                        <div class="content-view__location-wrapper">
                            <div class="content-view__map">
                                <a href="#"><img src="./img/map.jpg" width="361" height="292"
                                                 alt="Москва, Новый арбат, 23 к. 1"></a>
                            </div>
                            <div class="content-view__address">
                                <span class="address__town">Москва</span><br>
                                <span>Новый арбат, 23 к. 1</span>
                                <p>Вход под арку, код домофона 1122</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NOTE: buttons for displaying actions for the task author -->
                <?= TaskActionsButtonsWidget::widget(['task' => $task]); ?>
            </div>

            <?php
            /*
             * NOTE:
             * 1st condition - if there are responses
             *
             * 2nd condition-task author + if the current user matches
             * the task author id
             *
             * 3rd condition - for all other users, this block is not
             * shown (enabling - showing your own response to the author)
             * */

            if (
              $task->responds
              && $user->isCustomer()
              && $user->id == $task->owner_id
              || in_array(Yii::$app->user->identity->getId(), array_column($task->responds, 'user_id'))
            ): ?>

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
                                <a href="#"><img src="./img/<?= $respond->user->avatar->image_path; ?>" width="55" height="55"></a>
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

                            <?php if ($task->responds
                                && $user->isCustomer()
                                && $task->status_id != $task->isWork()
                            ): ?>
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
                        <img src="./img/<?= $task->owner->avatar->image_path; ?>" width="62" height="62" alt="Аватар заказчика">
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
            <div class="connect-desk__chat">
                <h3>Переписка</h3>
                <div class="chat__overflow">
                    <div class="chat__message chat__message--out">
                        <p class="chat__message-time">10.05.2019, 14:56</p>
                        <p class="chat__message-text">Привет. Во сколько сможешь
                            приступить к работе?</p>
                    </div>
                    <div class="chat__message chat__message--in">
                        <p class="chat__message-time">10.05.2019, 14:57</p>
                        <p class="chat__message-text">На задание
                        выделены всего сутки, так что через час</p>
                    </div>
                    <div class="chat__message chat__message--out">
                        <p class="chat__message-time">10.05.2019, 14:57</p>
                        <p class="chat__message-text">Хорошо. Думаю, мы справимся</p>
                    </div>
                </div>
                <p class="chat__your-message">Ваше сообщение</p>
                <form class="chat__form">
                    <textarea class="input textarea textarea-chat" rows="2" name="message-text" placeholder="Текст сообщения"></textarea>
                    <button class="button chat__button" type="submit">Отправить</button>
                </form>
            </div>
        </section>
    </div>

    <?= $this->render('//layouts/response', compact(
      'responseForm',
      'task')); ?>

    <?= $this->render('//layouts/cancel', ['taskId' => $task->id]); ?>
</main>
