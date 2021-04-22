<?php


namespace frontend\behaviors;

use DateTime;
use yii\base\Behavior;

class TemplateBehavior extends Behavior
{
    public function getPublishedTimeDiff($date)
    {
        $currentDate = new DateTime();
        $createDate = new DateTime($date);
        $interval = $currentDate->diff($createDate);

        return ($interval->d < 1)
            ? $interval->h . ' часа'
            : $interval->d . ' дней и ' . $interval->h . ' часа';
    }

}
