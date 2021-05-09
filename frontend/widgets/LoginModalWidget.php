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
    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('loginModal', ['model' => new LoginForm()]);
    }
}
