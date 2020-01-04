<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "task_file".
 *
 * @property int $id
 * @property string $image_path
 * @property int|null $task_id
 *
 * @property Task $task
 */
class TaskFile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'task_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['image_path'], 'required'],
            [['task_id'], 'integer'],
            [['image_path'], 'string', 'max' => 45],
            [['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::className(),
                'targetAttribute' => ['task_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'image_path' => 'Image Path',
            'task_id' => 'Task ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
}
