<?php

namespace frontend\widgets;

use yii\base\Widget;


class RatingWidget extends Widget
{
    public $currentRaiting;

    public function run()
    {
        $starsMax = 5;
        $starsFill = floor($this->currentRaiting);
        $starsEmpty = $starsMax - $starsFill;

        return $this->render('rating', compact('starsFill', 'starsEmpty'));
    }
}
