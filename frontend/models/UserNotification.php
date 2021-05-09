<?php

namespace app\models;

use frontend\models\Users;
use yii\db\{ActiveRecord, ActiveQuery};


/**
 * This is the model class for table "user_notification".
 *
 * @property int $id
 * @property int $user_id
 * @property int $notification_type
 * @property int $active
 *
 * @property Users $user
 */
class UserNotification extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'user_notification';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['user_id', 'notification_type', 'active'], 'required'],
            [['user_id', 'notification_type', 'active'], 'integer'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'notification_type' => 'Notification Type',
            'active' => 'Active',
        ];
    }

    /**
     * @note
     * gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}
