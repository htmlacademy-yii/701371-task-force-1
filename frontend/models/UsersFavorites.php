<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "users_favorites".
 *
 * @property int $id
 * @property int|null $favorites_account_id
 * @property int|null $account_id
 *
 * @property Users $favoritesAccount
 * @property Users $account
 */
class UsersFavorites extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users_favorites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['favorites_account_id', 'account_id'], 'integer'],
            [['favorites_account_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::className(),
                'targetAttribute' => ['favorites_account_id' => 'id']
            ],
            [['account_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::className(),
                'targetAttribute' => ['account_id' => 'id']
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
            'favorites_account_id' => 'Favorites Account ID',
            'account_id' => 'Account ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getFavoritesAccount(): ActiveQuery
    {
        return $this->hasOne(Users::className(),
            ['id' => 'favorites_account_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAccount(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'account_id']);
    }
}
