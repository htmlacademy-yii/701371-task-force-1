<?php

namespace frontend\modules\api\v1;

use yii\base\Module;

/**
 * api module definition class
 */
class ApiModule extends Module
{
    public $controllerNamespace = 'frontend\modules\api\v1\controllers';

    /**
     * @note
     * basic method
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
