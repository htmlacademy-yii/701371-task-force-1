<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


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
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'notification_type', 'active'], 'required'],
            [['user_id', 'notification_type', 'active'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
