<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;


/**
 * This is the model class for table "users_category".
 *
 * @property int $id
 * @property int|null $account_id
 * @property int|null $category_id
 *
 * @property Category $category
 * @property Users $account
 */
class UsersCategory extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'users_category';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'category_id'], 'integer'],
            [['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::class,
                'targetAttribute' => ['category_id' => 'id']
            ],
            [['account_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['account_id' => 'id']
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
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

    /**
     * @return ActiveQuery
     */
    public function getAccount(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'account_id']);
    }
}
