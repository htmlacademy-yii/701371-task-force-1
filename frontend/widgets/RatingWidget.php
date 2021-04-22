<?php

namespace frontend\widgets;

use yii\base\Widget;


/**
 * Class RatingWidget
 * @package frontend\widgets
 */
class RatingWidget extends Widget
{
    public int $currentRaiting;

    /**
     * @note
     * for counting rating
     *
     * @return string
     */
    public function run(): string
    {
        $starsMax = 5;
        $starsFill = floor($this->currentRaiting);
        $starsEmpty = $starsMax - $starsFill;

        return $this->render('rating', compact('starsFill', 'starsEmpty'));
    }
}
