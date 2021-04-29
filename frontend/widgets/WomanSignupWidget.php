<?php

namespace frontend\widgets;

use yii\base\Widget;


/**
 * Class WomanSignupWidget
 * @package frontend\components
 */
class WomanSignupWidget extends Widget
{
    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('woman');
    }
}
