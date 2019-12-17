<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users_avatar".
 *
 * @property int $id
 * @property string $image_path
 *
 * @property Users[] $users
 */
class UsersAvatar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_avatar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_path'], 'required'],
            [['image_path'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_path' => 'Image Path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['avatar_id' => 'id']);
    }
}
