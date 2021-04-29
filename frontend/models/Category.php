<?php

namespace frontend\models;

use yii\db\{ActiveRecord, ActiveQuery};


/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string $css_class
 *
 * @property Task[] $tasks
 * @property UsersCategory[] $usersCategories
 */
class Category extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'category';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'css_class'], 'required'],
            [['name'], 'string', 'max' => 32],
            [['css_class'], 'string', 'max' => 16],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'css_class' => 'Css Class',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(Task::class, ['category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsersCategories(): ActiveQuery
    {
        return $this->hasMany(UsersCategory::class, ['category_id' => 'id']);
    }
}
