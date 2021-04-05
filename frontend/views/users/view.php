<?php

use frontend\assets\UsersAsset;
use frontend\helpers\TaskPermissionHelper;
use frontend\models\Task;
use frontend\models\TaskRespond;
use frontend\models\Users;
use frontend\widgets\ElapsedTimeWidget;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Users $user;
 * @var String $userAge;
 * @var Task $userTasks
 * @var Task $task
 * @var TaskRespond $userResponds
 * @var TaskRespond $userRespond
 */

UsersAsset::register($this);

?>


<main class="page-main">
        <div class="main-container page-container">
            <section class="content-view">
                <div class="user__card-wrapper">
                    <div class="user__card">

                        <?= Html::img('@web/img/' . $user->getUserAvatarPath(),
                            [
                                'alt' => 'Аватар пользователя',
                                'style' => 'width: 120px; height: 120px;'
                            ]
                        ) ?>

                         <div class="content-view__headline">
                              <h1><?= $user->name; ?></h1>
                              <p><?= $user->city_id ? $user->city->title : ''; ?>, <?= $userAge; ?> лет</p>

                              <div class="profile-mini__name five-stars__rate">
                                  <?= RatingWidget::widget(['currentRaiting' => $user->getAverageRating()]); ?>
                                  <b><?= $user->getAverageRating(); ?></b>
                              </div>
                              <b class="done-task">Выполнил <?= count($userTasks); ?> заказов</b>
                              <b class="done-review">Получил <?= count($user->reviews); ?> отзывов</b>
                         </div>
                        <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                            <span>Был на сайте <?= ElapsedTimeWidget::widget(['timeStamp' => $user->visit]); ?> назад</span>
                             <a href="#"><b></b></a>
                        </div>
                    </div>

                    <div class="content-view__description">
                        <p><?= $user->about; ?></p>
                    </div>
                    <div class="user__card-general-information">
                        <div class="user__card-info">
                            <h3 class="content-view__h3">Специализации</h3>
                            <div class="link-specialization">

                                <?php foreach ($user->specializationsList as $specialization): ?>

                                    <!--
                                    NOTE:
                                    pass into the model UserFilter property categories->id of current category
                                    which we will then go to
                                    -->
                                    <a href="<?= Yii::$app->urlManager->createUrl(['users', 'UsersFilter' => ['categories' => $specialization->category->id]]); ?>" class="link-regular"><?= $specialization->category->name; ?></a>
                                <?php endforeach; ?>

                            </div>
                            <h3 class="content-view__h3">Контакты</h3>
                            <div class="user__card-link">
                                <a class="user__card-link--tel link-regular" href="#"><?= isset($user->contacts->phone) ? $user->contacts->phone : ''; ?></a>
                                <a class="user__card-link--email link-regular" href="#"><?= isset($user->contacts->messanger) ? $user->contacts->messanger : ''; ?></a>
                                <a class="user__card-link--skype link-regular" href="#"><?= isset($user->contacts->skype) ? $user->contacts->skype : ''; ?></a>
                            </div>
                         </div>
                        <div class="user__card-photo">
                            <h3 class="content-view__h3">Фото работ</h3>

                            <?php foreach ($user->usersImages as $images): ?>
                                <a href="#">
                                    <?= Html::img('@web/img/' . $images->image_path,
                                        [
                                            'alt' => 'Фото работы',
                                            'style' => 'width: 85px; height: 86px;'
                                        ]
                                    ) ?>
                                </a>
                            <?php endforeach; ?>
                         </div>
                    </div>
                </div>
                <div class="content-view__feedback">
                    <h2>Отзывы<span> <?= count($userResponds); ?></span></h2>
                    <div class="content-view__feedback-wrapper reviews-wrapper">

                        <?php foreach ($userTasks as $task): ?>

                            <div class="feedback-card__reviews">
                                <p class="link-task link">Задание <a href="<?= Url::to(['tasks/view', 'id' => $task->id]); ?>" class="link-regular">«<?= $task->title; ?>»</a></p>
                                <div class="card__review">
                                    <a href="#">
                                        <?= Html::img('@web/img/' . $task->getOwnerAvatarPath(),
                                            [
                                                'alt' => 'Аватар заказчика',
                                                'style' => 'width: 55px; height: 54px;'
                                            ]
                                        ) ?>
                                    </a>

                                    <div class="feedback-card__reviews-content">
                                        <p class="link-name link">
                                            <a href="#" class="link-regular"><?= $task->owner->name; ?></a>
                                        </p>

                                        <p class="review-text"><?= isset($userRespond->comment) ? $userRespond->comment : ''; ?></p>
                                    </div>
                                    <div class="card__review-rate">
                                        <p class="three-rate big-rate"><?= $user->averageRating; ?><span></span></p>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>
            </section>
            <section class="connect-desk">

                <?php if (TaskPermissionHelper::canUsersSeeChat($task)): ?>
                  <chat class="connect-desk__chat" task="<?= $task->id; ?>"></chat>
                <?php endif; ?>
            </section>
        </div>
</main>
