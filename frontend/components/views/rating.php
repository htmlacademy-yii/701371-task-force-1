<?php
/** @var TYPE_NAME $starsFill */
/** @var TYPE_NAME $starsEmpty */
?>

<?php for ($i = 0; $i < $starsFill; $i++): ?>
    <span></span>
<?php endfor; ?>

<?php for ($j = 0; $j < $starsEmpty; $j++): ?>
    <span class='star-disabled'></span>
<?php endfor; ?>
