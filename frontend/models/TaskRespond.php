<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "task_respond".
 *
 * @property int $id
 * @property string $comment
 * @property float $price
 * @property string $datetime
 * @property int|null $user_id
 * @property int|null $task_id
 * @property int|null $status_id
 *
 * @property Users $user
 * @property Task $task
 * @property TaskStatus $status
 */
class TaskRespond extends \yii\db\ActiveRecord
{
    // NOTE: noviy
    const STATUS_NEW = 1;

    // NOTE: prinytiy
    const STATUS_APPROVED = 2;

    // NOTE: otklonenniy
    const STATUS_REFUSED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_respond';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment', 'price'], 'required'],
            [['comment'], 'string'],
            [['price'], 'number'],
            [['datetime'], 'safe'],
            [['user_id', 'task_id', 'status_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'comment'   => 'Comment',
            'price'     => 'Price',
            'datetime'  => 'Datetime',
            'user_id'   => 'User ID',
            'task_id'   => 'Task ID',
            'status_id' => 'Status ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    // NOTE: my functions -----------------------------------------------------

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->status_id == self::STATUS_NEW;
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        return $this->status_id == self::STATUS_APPROVED;
    }

    /**
     * @return bool
     */
    public function isRefused()
    {
        return $this->status_id == self::STATUS_REFUSED;
    }
}
