<?php

namespace frontend\modules\api\controllers;

use frontend\models\Message;
use frontend\models\Task;
use yii\helpers\Json;
use yii\web\Controller;
use Yii;


class MessagesController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionGet($id)
    {
        $task = Task::findOne($id);
        $messages = Message::find()
            ->where([
                'task_id' => $id,

                /**
                 * NOTE:
                 * yii2 translates this to the - IN...
                 * task_id = ? AND sender_id IN (?, ?)
                 */
                'sender_id' => [
                    $task->executor_id,
                    $task->owner_id
                ]
            ])
            ->all();

        $data = [];
        foreach ($messages as $message) {
            $data[] = [
                'message' => $message->message,
                'published_at' => $message->published_at,
                'is_mine' => Yii::$app->user->identity->getId() == $message->sender_id,
            ];
        }

        \Yii::$app->end(Json::encode($data));
    }

    public function actionCreate(int $id)
    {
        Yii::$app->response->setStatusCode(201);
        $task = Task::findOne($id);

        $message = new Message();
        $message->sender_id = Yii::$app->user->identity->getId();
        $message->reciever_id = $task->executor_id;
        $message->task_id = $task->id;

        $messageCurrent = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $message->message = $messageCurrent['message'];
        $message->published_at = date("Y-m-d H:i:s");

        $message->save();

        // NOTE: stopping processing of all requests
        Yii::$app->end(Json::encode([
            'id' => $message->id,
            'message' => $message->message,
            'published_at' => $message->published_at,
            'is_mine' => Yii::$app->user->identity->getId() == $message->sender_id
        ]));
    }

    public function actionView(int $id)
    {
        return Message::find()->where(['reciver_id' => $id])->all();
    }
}
