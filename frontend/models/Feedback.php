<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "feedback".
 *
 * @property int $id
 * @property int|null $rating_id
 * @property int|null $account_id
 * @property int|null $task_id
 * @property int|null $status_id
 *
 * @property Task $task
 * @property Users $account
 * @property FeedbackStatus $status
 */
class Feedback extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rating_id', 'account_id', 'task_id', 'status_id'], 'integer'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeedbackStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rating_id' => 'Rating ID',
            'account_id' => 'Account ID',
            'task_id' => 'Task ID',
            'status_id' => 'Status ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAccount(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'account_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStatus(): ActiveQuery
    {
        return $this->hasOne(FeedbackStatus::className(), ['id' => 'status_id']);
    }
}
