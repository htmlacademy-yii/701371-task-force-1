<?php

use yii\db\Migration;

/**
 * Class m210507_210508_fill_content_task_status_table
 */
class m210507_210508_fill_content_task_status_table extends Migration
{
    /**
     * @note
     * fill tasks_status
     */
    public function safeUp(): void
    {
        /**
         * @note
         * tasks_status
         */

        $this->batchInsert(\frontend\models\TaskStatus::tableName(),
            ['title'],
            [
                ['respond'],
                ['cancel'],
                ['completed'],
                ['fail'],
                ['work'],
                ['new'],
            ]
        );
    }

    /**
     * @note
     * clean task
     */
    public function safeDown(): void
    {
        $this->delete(\frontend\models\TaskStatus::tableName());
    }
}
