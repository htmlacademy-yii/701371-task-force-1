<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;


/**
 * @note
 * this is the model class for table "message".
 *
 * @property int $id
 * @property string $message
 * @property int|null $sender_id
 * @property int|null $reciever_id
 * @property int|null $task_id
 * @property string $published_at
 *
 * @property Users $sender
 * @property Users $reciever
 */
class Message extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'message';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['message'], 'required'],
            [['message'], 'string'],
            [['sender_id', 'reciever_id', 'task_id'], 'integer'],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['sender_id' => 'id']],
            [['reciever_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['reciever_id' => 'id']],
            [['published_at'], 'safe'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'sender_id' => 'Sender ID',
            'reciever_id' => 'Reciever ID',
            'task_id' => 'Task ID',
            'published_at' => 'Data Time',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSender(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'sender_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getReciever(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'reciever_id']);
    }
}
