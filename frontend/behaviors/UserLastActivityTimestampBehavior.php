<?php

namespace frontend\behaviors;

use frontend\models\Users;
use Yii;
use yii\base\Behavior;
use yii\db\Expression;
use yii\web\Controller;


/**
 * Class UserLastActivityTimestampBehavior
 * @package frontend\behaviors
 */
class UserLastActivityTimestampBehavior extends Behavior
{
    /**
     * @return array
     */
    public function events(): array
    {
        return [Controller::EVENT_BEFORE_ACTION => 'setTimestamp'];
    }

    /**
     * @note
     * for set Timestamp
     */
    public function setTimestamp(): void
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        $user = Users::findOne(Yii::$app->user->identity->getId());
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
