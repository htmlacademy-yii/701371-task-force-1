<?php

use frontend\assets\UsersAsset;
use frontend\helpers\TaskPermissionHelper;
use frontend\models\Task;
use frontend\models\TaskRespond;
use frontend\models\Users;
use frontend\widgets\ElapsedTimeWidget as ElapsedTimeWidgetAlias;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Users $user
 * @var String $userAge
 * @var Task $userTask
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

                                  <?php try {
                                      echo RatingWidget::widget(['currentRating' => $user->getAverageRating()]);
                                  } catch (Exception $e) {} ?>

                                  <b><?= $user->getAverageRating(); ?></b>
                              </div>
                              <b class="done-task">Выполнил <?= count($user->tasks); ?> заказов</b>
                              <b class="done-review">Получил <?= count($user->reviews); ?> отзывов</b>
                         </div>
                        <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                            <span>Был на сайте

                                <?php try {
                                    echo ElapsedTimeWidgetAlias::widget(['timeStamp' => $user->visit]);
                                } catch (Exception $e) {} ?>

                              назад</span>
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

                                <?php
                                /**
                                 * isset($user->contacts->phone) ? $user->contacts->phone : '';
                                 * can use as
                                 * $user->contacts->phone ?? ''
                                 * where ?? - replaced a isset
                                 */
                                ?>
                                <a class="user__card-link--tel link-regular" href="#"><?= $user->contacts->phone ?? ''; ?></a>
                                <a class="user__card-link--email link-regular" href="#"><?= $user->contacts->messanger ?? ''; ?></a>
                                <a class="user__card-link--skype link-regular" href="#"><?= $user->contacts->skype ?? ''; ?></a>
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
                    <h2>Отзывы<span> <?= count($user->reviews); ?></span></h2>
                    <div class="content-view__feedback-wrapper reviews-wrapper">

                        <?php foreach ($user->reviews as $review): ?>

                            <div class="feedback-card__reviews">
                                <p class="link-task link">Задание <a href="<?= Url::to(['tasks/view', 'id' => $review->task_id]); ?>" class="link-regular">«<?= $review->task->title; ?>»</a></p>
                                <div class="card__review">
                                    <a href="#">
                                        <?= Html::img('@web/img/' . $review->task->getOwnerAvatarPath(),
                                            [
                                                'alt' => 'Аватар заказчика',
                                                'style' => 'width: 55px; height: 54px;'
                                            ]
                                        ) ?>
                                    </a>

                                    <div class="feedback-card__reviews-content">
                                        <p class="link-name link">
                                            <a href="#" class="link-regular"><?= $review->task->owner->name; ?></a>
                                        </p>

                                        <p class="review-text"><?= $review->description; ?></p>
                                    </div>
                                    <div class="card__review-rate">
                                        <p class="three-rate big-rate"><?= $review->task->executor->averageRating; ?><span></span></p>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>
            </section>
            <section class="connect-desk">

                <?php if ($userTask && TaskPermissionHelper::canUsersSeeChat($userTask)): ?>
                    <chat class="connect-desk__chat" task="<?= $userTask->id; ?>"></chat>
                <?php endif; ?>

            </section>
        </div>
</main>
