<?php
/** @var int $starsFill */
/** @var int $starsEmpty */
?>

<?php for ($i = 0; $i < $starsFill; $i++): ?>
    <span></span>
<?php endfor; ?>

<?php for ($j = 0; $j < $starsEmpty; $j++): ?>
    <span class='star-disabled'></span>
<?php endfor; ?>
