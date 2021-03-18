<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;


/**
 * @note
 * this is the model class for table "feedback_status".
 *
 * @property int $id
 * @property string $title
 *
 * @property Feedback[] $feedbacks
 */
class FeedbackStatus extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string'],
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
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getFeedbacks(): ActiveQuery
    {
        return $this->hasMany(Feedback::className(), ['status_id' => 'id']);
    }
}
