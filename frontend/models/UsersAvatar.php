<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "users_avatar".
 *
 * @property int $id
 * @property string $image_path
 *
 * @property Users[] $signup
 */
class UsersAvatar extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users_avatar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['image_path'], 'required'],
            [['image_path'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'image_path' => 'Image Path',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(Users::className(), ['avatar_id' => 'id']);
    }
}
