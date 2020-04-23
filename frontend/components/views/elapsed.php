<?php
use frontend\helpers\PluralFormHelper;

/** @var DateInterval $interval */
?>

<?php if ($interval->y >= 1): ?>
    <?= $interval->y; ?>
    <?= PluralFormHelper::format(
        $interval->y, 'год', 'года', 'лет'
    ); ?>
<?php endif; ?>

<?php if ($interval->m >= 1): ?>
    <?= $interval->m; ?>
    <?= PluralFormHelper::format(
        $interval->m, 'месяц', 'месяца', 'месяцев'
    ); ?>
<?php endif; ?>

<?php if ($interval->d >= 1): ?>
    <?= $interval->d; ?>
    <?= PluralFormHelper::format(
        $interval->d, 'день', 'дня', 'дней'
    ); ?>
<?php endif; ?>

<?= $interval->h; ?>
<?= PluralFormHelper::format(
    $interval->h, ' час', ' часа', ' часов'
); ?>
