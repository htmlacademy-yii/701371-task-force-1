<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;


/**
 * This is the model class for table "task_status".
 *
 * @property int $id
 * @property string $title
 *
 * @property Task[] $tasks
 */
class TaskStatus extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(Task::className(), ['status_id' => 'id']);
    }
}
