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
     * @return string
     */
    public static function tableName(): string
    {
        return 'notification';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['new_messages', 'task_actions', 'new_responds'], 'required'],
            [['new_messages', 'task_actions', 'new_responds'], 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
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
        return $this->hasMany(Users::class, ['notification_id' => 'id']);
    }
}
