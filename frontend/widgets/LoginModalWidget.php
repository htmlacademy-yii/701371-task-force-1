<?php

namespace frontend\widgets;

use frontend\models\forms\LoginForm;
use yii\base\Widget;


/**
 * Class LoginModalWidget
 * @package frontend\widgets
 */
class LoginModalWidget extends Widget
{
    public function run()
    {
        return $this->render('loginModal', ['model' => new LoginForm()]);
    }
}
