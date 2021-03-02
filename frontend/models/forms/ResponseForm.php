<?php

namespace frontend\models\forms;

use frontend\models\TaskRespond;
use Yii;
use yii\base\Model;


class ResponseForm extends Model
{
    public $price;
    public $comment;

    public function attributeLabels(): array
    {
        return [
            'price'   => 'Ваша цена',
            'comment' => 'Комментарий',
        ];
    }

    public function rules(): array
    {
        return [
            [['price', 'comment'], 'required'],
            [['comment'], 'string'],
            [['price'], 'integer'],
        ];
    }

    public function createResponse()
    {
        $respond = new TaskRespond();
        $respond->comment = $this->comment;
        $respond->price = $this->price;

        $respond->datetime = date("Y-m-d H:i:s");
        $respond->user_id = Yii::$app->user->identity->getId();

        $respond->task_id = 2;
        $respond->status_id = TaskRespond::STATUS_NEW;

        if (!$respond->save()) {
            return false;
        }

        return true;
    }
}
