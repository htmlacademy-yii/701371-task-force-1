<?php

namespace app\models;

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
    public function rules()
    {
        return [
            [['user_id', 'notification_type', 'active'], 'required'],
            [['user_id', 'notification_type', 'active'], 'integer'],

            // NOTE: causes an error
            /*
            [['user_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['user_id' => 'id']],
            */
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'notification_type' => 'Notification Type',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
