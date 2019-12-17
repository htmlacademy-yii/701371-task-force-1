<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users_image".
 *
 * @property int $id
 * @property string $image_path
 * @property int|null $account_id
 *
 * @property Users $account
 */
class UsersImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_path'], 'required'],
            [['account_id'], 'integer'],
            [['image_path'], 'string', 'max' => 45],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['account_id' => 'id']],
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
            'account_id' => 'Account ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Users::className(), ['id' => 'account_id']);
    }
}
