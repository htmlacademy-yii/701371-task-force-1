<?php

namespace frontend\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 * @note
 * this is the model class for table "reviews".
 *
 * @property int $id
 * @property string $description
 * @property float $raiting
 * @property string $created
 * @property float $price
 * @property int|null $status_id
 * @property int|null $account_id
 *
 * @property Users $account
 * @property TaskStatus $status
 * @property Users[] $users
 */
class Reviews extends ActiveRecord
{
    const STATUS_NEW = 1;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'reviews';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['description', 'raiting', 'price'], 'required'],
            [['description'], 'string'],
            [['raiting', 'price'], 'number'],
            [['created'], 'safe'],
            [['status_id', 'account_id'], 'integer'],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['account_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatus::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'raiting' => 'Raiting',
            'created' => 'Created',
            'price' => 'Price',
            'status_id' => 'Status ID',
            'account_id' => 'Account ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAccount(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'account_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStatus(): ActiveQuery
    {
        return $this->hasOne(TaskStatus::class, ['id' => 'status_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(Users::class, ['raiting_id' => 'id']);
    }
}
