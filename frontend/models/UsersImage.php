<?php

namespace frontend\models;

use yii\db\{ActiveRecord, ActiveQuery};


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
     * @return string
     */
    public static function tableName(): string
    {
        return 'users_image';
    }

    /**
     * @return array
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
                'targetClass' => Users::class,
                'targetAttribute' => ['account_id' => 'id']
            ],
        ];
    }

    /**
     * @return array
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
        return $this->hasMany(Users::class, ['id' => 'account_id']);
    }
}
