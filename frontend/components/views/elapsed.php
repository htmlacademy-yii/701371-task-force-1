<?php
use frontend\helpers\PluralFormHelper;

/** @var DateInterval $interval */
?>

<?php if ((int) $interval->d >= 1): ?>
    <?= $interval->d; ?>
    <?= PluralFormHelper::format(
        $interval->d, 'день', 'дня', 'дней'
    ); ?>
<?php endif; ?>

<?= $interval->h; ?>
<?= PluralFormHelper::format(
    $interval->h, 'час', 'часа', 'часов'
); ?>
