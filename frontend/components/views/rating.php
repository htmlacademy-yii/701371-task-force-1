<?php
/** @var TYPE_NAME $starsFill */
/** @var TYPE_NAME $starsEmpty */

for ($i = 0; $i < $starsFill; $i++) {
    echo "<span></span>";
}

for ($j = 0; $j < $starsEmpty; $j++) {
    echo "<span class='star-disabled'></span>";
}

