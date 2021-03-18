<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;


/**
 * This is the model class for table "users_avatar".
 *
 * @property int $id
 * @property string $image_path
 * @property int|null $account_id
 *
 * @property Users[] $users
 */
class UsersAvatar extends ActiveRecord
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
    public function rules(): array
    {
        return [
            [['image_path'], 'required'],
            [['image_path'], 'string', 'max' => 45],
            [['account_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'image_path' => 'account ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['account_id' => 'id']);
    }
}
