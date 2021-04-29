<?php

namespace frontend\models;

use yii\db\{ActiveRecord, ActiveQuery};


/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $title
 * @property string $latitude
 * @property string $longitude
 *
 * @property Task[] $tasks
 * @property Users[] $users
 */
class City extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'city';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title', 'latitude', 'longitude'], 'required'],

            [['latitude', 'longitude'], 'number'],
            [['latitude', 'longitude'], 'string', 'max' => 24],

            [['title'], 'string', 'max' => 32],
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
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(Task::class, ['city_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(Users::class, ['city_id' => 'id']);
    }
}
