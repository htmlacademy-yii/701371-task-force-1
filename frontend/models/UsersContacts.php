<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "users_contacts".
 *
 * @property int $id
 * @property int $phone
 * @property string $skype
 * @property string $messanger
 *
 * @property Users[] $signup
 */
class UsersContacts extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users_contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['phone', 'skype', 'messanger'], 'required'],
            [['phone'], 'integer'],
            [['skype', 'messanger'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'messanger' => 'Messanger',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(Users::className(), ['contacts_id' => 'id']);
    }
}
