<?php

namespace frontend\models;

use Yii;
use yii\db\{ActiveRecord, ActiveQuery};

/**
 * This is the model class for table "users_roles".
 *
 * @property int $id
 * @property string $title
 * @property string $key_code
 *
 * @property Users[] $users
 */
class UsersRoles extends ActiveRecord
{
    const CUSTOMER_KEY_CODE = 'customer';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'key_code'], 'required'],
            [['title'], 'string', 'max' => 32],
            [['key_code'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'key_code' => 'Key Code',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(Users::className(), ['role_id' => 'id']);
    }

    public function isCustomer()
    {
        return $this->key_code == self::CUSTOMER_KEY_CODE;
    }
}
