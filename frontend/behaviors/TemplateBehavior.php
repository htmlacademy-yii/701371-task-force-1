<?php


namespace frontend\behaviors;

use DateTime;
use Exception;
use yii\base\Behavior;


/**
 * Class TemplateBehavior
 * @package frontend\behaviors
 */
class TemplateBehavior extends Behavior
{
    /**
     * @param $date
     * @return string
     * @throws Exception
     */
    public function getPublishedTimeDiff($date): string
    {
        $currentDate = new DateTime();
        $createDate = new DateTime($date);
        $interval = $currentDate->diff($createDate);

        return ($interval->d < 1)
            ? $interval->h . ' часа'
            : $interval->d . ' дней и ' . $interval->h . ' часа';
    }

}
