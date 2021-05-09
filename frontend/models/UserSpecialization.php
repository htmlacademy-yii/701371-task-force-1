<?php

namespace frontend\models;

use yii\db\{ActiveRecord, ActiveQuery};


/**
 * @note
 * This is the model class for table "user_specialization".
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 *
 * @property Category $category
 */
class UserSpecialization extends ActiveRecord
{
    /**
     * @note
     * set table name
     *
     * @return string
     */
    public static function tableName(): string
    {
        return 'user_specialization';
    }

    /**
     * @note
     * for rules validation
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [['category_id', 'user_id'], 'required'],
            [['category_id'], 'integer'],
            [['user_id'], 'integer'],
        ];
    }

    /**
     * @note
     * for labels
     *
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}
