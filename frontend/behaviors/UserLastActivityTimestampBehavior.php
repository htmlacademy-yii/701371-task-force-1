<?php

namespace frontend\behaviors;

use frontend\models\Users;
use yii\base\Behavior;
use yii\db\Expression;
use yii\web\Controller;

class UserLastActivityTimestampBehavior extends Behavior
{
    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'setTimestamp'];
    }

    public function setTimestamp()
    {
        if (\Yii::$app->user->isGuest) {
            return;
        }

        $user = Users::findOne(\Yii::$app->user->identity->getId());
        if (!$user) {
            return;
        }

        /**
         * @note
         * save only one method and updating this in DB
         */
        $user->updateAttributes([
            'visit' => new Expression('NOW()')
        ]);
    }
}
