<?php

namespace frontend\widgets;

use DateTime;
use yii\base\Widget;


/**
 * Class ElapsedTimeWidget
 * @package frontend\widgets
 */
class ElapsedTimeWidget extends Widget
{
    public $timeStamp;

    public function run()
    {
        $currentDate = new DateTime();
        $createDate = new DateTime($this->timeStamp);
        $interval = $currentDate->diff($createDate);

        return $this->render('elapsed', compact('interval'));
    }
}
