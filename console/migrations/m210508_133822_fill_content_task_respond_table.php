<?php

use yii\db\Migration;

/**
 * Class m210508_133822_fill_content_task_respond_table
 */
class m210508_133822_fill_content_task_respond_table extends Migration
{
    /**
     * @note
     * fill messages
     */
    public function safeUp(): void
    {
        /**
         * @note
         * task_respond
         */
        $this->batchInsert(\frontend\models\TaskRespond::tableName(),
            ['comment', 'price', 'user_id', 'task_id', 'status_id'],
            [
                ['Могу сделать все в лучшем виде', 1500, 1, 1, 3],
                ['Примусь за выполнение в течении часа', 1500, 3, 2, 1],
                ['Забацаю любое задание! Быстро и в срок!', 1500, 3, 3, 1],
                ['power overwhelming', 1500, 8, 4, 3],
            ]
        );
    }

    /**
     * @note
     * clean task_respond
     */
    public function safeDown(): void
    {
        $this->delete(\frontend\models\TaskRespond::tableName());
    }
}
