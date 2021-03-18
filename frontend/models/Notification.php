<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;


/**
 * @note
 * this is the model class for table "notification".
 *
 * @property int $id
 * @property int $new_messages
 * @property int $task_actions
 * @property int $new_responds
 *
 * @property Users[] $users
 */
class Notification extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['new_messages', 'task_actions', 'new_responds'], 'required'],
            [['new_messages', 'task_actions', 'new_responds'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'new_messages' => 'New Messages',
            'task_actions' => 'Task Actions',
            'new_responds' => 'New Responds',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(Users::className(), ['notification_id' => 'id']);
    }
}
