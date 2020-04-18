<?php

namespace frontend\models;

use DateTime;
use Yii;

/**
 * This is the model class for table "reviews".
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
 * @property Users[] $signup
 */
class Reviews extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'raiting', 'price'], 'required'],
            [['description'], 'string'],
            [['raiting', 'price'], 'number'],
            [['created'], 'safe'],
            [['status_id', 'account_id'], 'integer'],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Users::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(TaskStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['raiting_id' => 'id']);
    }


    // NOTE: my functions -----------------------------------------------------


}
