<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users_roles".
 *
 * @property int $id
 * @property string $title
 * @property string $key_code
 *
 * @property Users[] $users
 */
class UsersRoles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'key_code' => 'Key Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['role_id' => 'id']);
    }
}
