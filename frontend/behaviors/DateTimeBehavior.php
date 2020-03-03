<?php


namespace frontend\behaviors;

use DateTime;
use yii\base\Behavior;

class DateTimeBehavior extends Behavior
{
    //public $attributeName;
    //
    //public function init()
    //{
    //    $property = $this->attributeName;
    //
    //    if ($this->{$property} && !$this->{$property} instanceOf DateTime) {
    //        $this->{$property} = new DateTime($this->{$property});
    //    }
    //}

    public function getPublishedTimeDiff($date)
    {
        $currentDate = new DateTime();
        $createDate = new DateTime($date);
        $interval = $currentDate->diff($createDate);

        $elapsedTime = ((int)$interval->d < 1)
            ? $interval->h . ' часа'
            : (int)$interval->d . ' дней и ' . $interval->h . ' часа';

        return $elapsedTime;
    }

}
