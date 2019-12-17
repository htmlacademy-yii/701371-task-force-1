<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users_contacts".
 *
 * @property int $id
 * @property int $phone
 * @property string $skype
 * @property string $messanger
 *
 * @property Users[] $users
 */
class UsersContacts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'messanger' => 'Messanger',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['contacts_id' => 'id']);
    }
}
