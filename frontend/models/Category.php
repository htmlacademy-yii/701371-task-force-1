<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

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
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'css_class'], 'required'],
            [['name'], 'string', 'max' => 32],
            [['css_class'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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
        return $this->hasMany(Task::className(), ['category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsersCategories(): ActiveQuery
    {
        return $this->hasMany(UsersCategory::className(), ['category_id' => 'id']);
    }
}
