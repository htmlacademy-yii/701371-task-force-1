<?php
use frontend\helpers\PluralFormHelper;

/** @var DateInterval $interval */
?>


<?php if ($interval->y >= 1): ?>
    <?= $interval->y; ?>
    <?= PluralFormHelper::format(
        $interval->y, 'год', 'года', 'лет'
    ); ?>
<?php elseif ($interval->m >= 1): ?>
    <?= $interval->m; ?>
    <?= PluralFormHelper::format(
        $interval->m, 'месяц', 'месяца', 'месяцев'
    ); ?>
<?php elseif ($interval->d >= 1): ?>
    <?= $interval->d; ?>
    <?= PluralFormHelper::format(
        $interval->d, 'день', 'дня', 'дней'
    ); endif; ?>

<?php if ($interval->h > 1) {
    echo $interval->h;
    echo PluralFormHelper::format(
        $interval->h, ' час', ' часа', ' часов'
    );
}  else {
    echo ' менее 1 часа';
} ?>
