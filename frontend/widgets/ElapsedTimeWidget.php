<?php

namespace frontend\widgets;

use DateTime;
use Exception;
use yii\base\Widget;


/**
 * Class ElapsedTimeWidget
 * @package frontend\widgets
 */
class ElapsedTimeWidget extends Widget
{
    public string $timeStamp;

    /**
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        $currentDate = new DateTime();
        $createDate = new DateTime($this->timeStamp);
        $interval = $currentDate->diff($createDate);

        return $this->render('elapsed', compact('interval'));
    }
}
