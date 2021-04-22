<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;


/**
 * This is the model class for table "users_contacts".
 *
 * @property int $id
 * @property int $phone
 * @property string $skype
 * @property string $messanger
 * @property int $account_id
 *
 * @property Users[] $users
 */
class UsersContacts extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'users_contacts';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['phone', 'skype', 'messanger'], 'safe'],
            [['account_id'], 'integer'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'messanger' => 'Messanger',
            'account_id' => 'AccountId',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(Users::class, ['contacts_id' => 'id']);
    }
}
