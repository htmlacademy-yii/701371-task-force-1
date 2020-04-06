<?php

namespace frontend\components;

use DateTime;
use yii\base\Widget;

class ElapsedTimeWidget extends Widget
{
    public $currentTime;

    public function run()
    {
        $currentDate = new DateTime();
        $createDate = new DateTime($this->currentTime);
        $interval = $currentDate->diff($createDate);

        return $this->render('elapsed', compact('interval'));
    }
}
