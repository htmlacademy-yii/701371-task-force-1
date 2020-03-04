<?php
/** @var TYPE_NAME $interval */
?>

<?php if ( (int)$interval->d < 1 ): ?>
    <?= $interval->h . ' часа'; ?>
<?php endif; ?>

<?php if ( (int)$interval->d >= 1 ): ?>
    <?= (int)$interval->d . ' дней и ' . $interval->h . ' часа'; ?>
<?php endif; ?>
