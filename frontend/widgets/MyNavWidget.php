<?php


namespace frontend\widgets;

use yii\bootstrap\Nav;
use yii\helpers\Html;


/**
 * Class MyNavWidget
 * @package frontend\widgets
 */
class MyNavWidget extends Nav
{
    public function init()
    {
        parent::init();

        Html::removeCssClass($this->options, 'nav');
    }
}
