<?php

namespace frontend\models;

use yii\db\{ActiveQuery, ActiveRecord};


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
class TaskRespond extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REFUSED = 3;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'task_respond';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['comment', 'price'], 'required'],
            [['comment'], 'string'],
            [['price'], 'number'],
            [['datetime'], 'safe'],
            [['user_id', 'task_id', 'status_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatus::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'comment' => 'Comment',
            'price' => 'Price',
            'datetime' => 'Datetime',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
            'status_id' => 'Status ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }


    /** @note my functions ------------------------------------------------- */

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->status_id == self::STATUS_NEW;
    }

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->status_id == self::STATUS_APPROVED;
    }

    /**
     * @return bool
     */
    public function isRefused(): bool
    {
        return $this->status_id == self::STATUS_REFUSED;
    }
}
