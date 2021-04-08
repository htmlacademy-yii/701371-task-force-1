<?php

namespace frontend\models\forms;

use frontend\models\TaskRespond;
use Yii;
use yii\base\Model;
use yii\helpers\Html;


/**
 * Class ResponseForm
 * @package frontend\models\forms
 */
class ResponseForm extends Model
{
    public $price;
    public $comment;
    public $taskId;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['price', 'comment', 'taskId'], 'required'],
            [['comment'], 'string'],
            [['price', 'taskId'], 'integer'],

            [['comment'], 'filter', 'filter' => [Html::class, 'encode']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'price' => 'Ваша цена',
            'comment' => 'Комментарий',
            'taskId' => 'TaskID',
        ];
    }

    /**
     * @note
     * creating and saving the response
     *
     * @return bool
     */
    public function createResponse(): bool
    {
        $respond = new TaskRespond();
        $respond->comment = $this->comment;
        $respond->price = $this->price;

        $respond->datetime = date("Y-m-d H:i:s");
        $respond->user_id = Yii::$app->user->identity->getId();

        $respond->task_id = $this->taskId;
        $respond->status_id = TaskRespond::STATUS_NEW;

        if (!$respond->save()) {
            return false;
        }

        return true;
    }
}
