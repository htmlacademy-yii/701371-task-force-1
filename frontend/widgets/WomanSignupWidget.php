<?php

namespace frontend\components;

use yii\base\Widget;


/**
 * Class WomanSignupWidget
 * @package frontend\components
 */
class WomanSignupWidget extends Widget
{
    public function run()
    {
        return $this->render('woman');
    }
}
