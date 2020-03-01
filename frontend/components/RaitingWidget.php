<?php

namespace frontend\components;

use yii\base\Widget;

class RaitingWidget extends Widget
{
    public $currentRaiting;

    public function run()
    {
        $starsMax = 5;
        $starsFill = floor($this->currentRaiting);
        $starsEmpty = $starsMax - $starsFill;

        for ($i = 0; $i < $starsFill; $i++) {
            echo "<span></span>";
        }

        for ($j = 0; $j < $starsEmpty; $j++) {
            echo "<span class='star-disabled'></span>";
        }
    }
}
