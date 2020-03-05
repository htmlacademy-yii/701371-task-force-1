
<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use frontend\components\RatingWidget;
use frontend\components\ElapsedTimeWidget;
//use frontend\models\TaskFilter;
//use frontend\models\Reviews;

// NOTE: for pagination
use yii\widgets\LinkPager;

/**
 * @var Task[] $task
 * @var Task[] $customerOrders
 * @var Task[] $customerReviews
 * @var Review[] $customerRaiting
 * @var Review[] $reviews
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
                <div class="content-view__action-buttons">
                        <button class=" button button__big-color response-button"
                                type="button">Откликнуться</button>
                        <button class="button button__big-color refusal-button"
                                type="button">Отказаться</button>
                        <button class="button button__big-color connection-button"
                                type="button">Написать сообщение</button>
                </div>
            </div>
            <div class="content-view__feedback">
                <h2>Отклики <span>(2)</span></h2>
                <div class="content-view__feedback-wrapper">
                    <?php foreach ($reviews as $review): ?>
                        <div class="content-view__feedback-card">
                            <div class="feedback-card__top">
                                <a href="#"><img src="./img/<?= $review->account->avatar->image_path; ?>" width="55" height="55"></a>
                                <div class="feedback-card__top--name">

                                    <p><a href="#" class="link-regular"><?= $review->account->name; ?></a></p>
                                    <?php echo RatingWidget::widget(['currentRaiting' => $review->raiting]); ?>
                                    <b><?= $review->raiting; ?></b>

                                </div>
                                <span class="new-task__time"><?= ElapsedTimeWidget::widget(['currentTime' => $review->created]); ?> назад</span>
                            </div>
                            <div class="feedback-card__content">
                                <p><?= $review->description; ?></p>
                                <span><?= $review->price; ?></span>

                            </div>
                            <div class="feedback-card__actions">
                                <button class="button__small-color response-button button"
                                        type="button">Откликнуться</button>
                                <button class="button__small-color refusal-button button"
                                        type="button">Отказаться</button>
                                <button class="button__chat button"
                                        type="button"></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <section class="connect-desk">
            <div class="connect-desk__profile-mini">
                <div class="profile-mini__wrapper">
                    <h3>Заказчик</h3>
                    <div class="profile-mini__top">
                        <img src="./img/<?= $task->owner->avatar->image_path; ?>" width="62" height="62" alt="Аватар заказчика">
                        <div class="profile-mini__name five-stars__rate">

                            <p><?= $task->owner->name; ?></p>
                            <?php echo RatingWidget::widget(['currentRaiting' => $customerRaiting]); ?>
                            <b><?= round($customerRaiting, 2); ?></b>

                        </div>
                    </div>
                    <p class="info-customer">
                        <span><?= $customerReviews; ?> отзывов</span>
                        <span class="last-"><?= count($customerOrders); ?> заказов</span>
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
</main>
