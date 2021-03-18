<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;


/**
 * @note
 * this is the model class for table "users_image".
 *
 * @property int $id
 * @property string $image_path
 * @property int|null $account_id
 *
 * @property UsersImage[] $imagesList
 */
class UsersImage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['image_path'], 'required'],
            [['account_id'], 'integer'],
            [['image_path'], 'string', 'max' => 45],
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
            'image_path' => 'Image Path',
            'account_id' => 'Account ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getImagesList(): ActiveQuery
    {
        return $this->hasMany(Users::className(), ['id' => 'account_id']);
    }
}
