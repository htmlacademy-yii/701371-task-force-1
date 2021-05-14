<?php

use yii\db\Migration;

/**
 * Class m200704_205908_task_respond_add_status
 */
class m200704_205908_task_respond_add_status extends Migration
{
    /**
     * @note
     * insert data into the table
     */
    public function safeUp(): void
    {
        $this->truncateTable(\frontend\models\TaskRespond::tableName());

        $this->batchInsert(
            \frontend\models\TaskRespond::tableName(),
            ['comment', 'price', 'user_id', 'task_id', 'status_id'],
            [
                ['Могу сделать все в лучшем виде', 1500, 1, 2, 1],
                ['Примусь за выполнение в течении часа', 1500, 3, 2, 1],
                ['Забацаю любое задание! Быстро и в срок!', 4500, 3, 2, 1],
            ]
        );
    }

    /**
     * @note
     * return default data
     */
    public function safeDown(): void
    {
        $this->truncateTable(\frontend\models\TaskRespond::tableName());

        $this->batchInsert(
            \frontend\models\TaskRespond::tableName(),
            ['comment', 'price', 'user_id', 'task_id'],
            [
                ['Могу сделать все в лучшем виде', 1500, 1, 2],
                ['Примусь за выполнение в течении часа', 1500, 3, 3],
            ]
        );
    }
}
