<?php

namespace frontend\models;

use yii\db\{ActiveRecord, ActiveQuery};


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
     * @return string
     */
    public static function tableName(): string
    {
        return 'feedback_status';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'string'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
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
        return $this->hasMany(Feedback::class, ['status_id' => 'id']);
    }
}
