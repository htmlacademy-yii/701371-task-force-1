<?php

namespace frontend\models;

use yii\db\{ActiveRecord, ActiveQuery};


/**
 * @note
 * this is the model class for table "reviews".
 *
 * @property int $id
 * @property string $description
 * @property string $created
 * @property float $rating
 * @property int $task_id
 *
 * @property Task $task
 */
class Reviews extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'reviews';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['description', 'rating'], 'required'],
            [['description'], 'string'],
            [['rating'], 'number'],
            [['created'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'rating' => 'Rating',
            'created' => 'Created',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }
}
