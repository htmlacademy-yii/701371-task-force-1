<?php

namespace frontend\models;

use yii\db\{ActiveRecord, ActiveQuery};


/**
 * @note
 * this is the model class for table "task_status".
 *
 * @property int $id
 * @property string $title
 *
 * @property Task[] $tasks
 */
class TaskStatus extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'task_status';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'string'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
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
        return $this->hasMany(Task::class, ['status_id' => 'id']);
    }
}
