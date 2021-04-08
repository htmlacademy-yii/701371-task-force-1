<?php

namespace frontend\models;

use yii\db\ActiveQuery;


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
class UserSpecialization extends \yii\db\ActiveRecord
{
    /**
     * @note
     * set table name
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_specialization';
    }

    /**
     * @note
     * for rules validation
     *
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * @return \yii\db\ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}
