<?php

use yii\db\Migration;

/**
 * Migration for add additional column with id to message table
 *
 * Class m201107_134123_add_task_id_column_to_message_table
 */
class m201107_134123_add_task_id_column_to_message_table extends Migration
{
    /**
     * @note
     * Add id column to message table
     */
    public function safeUp(): void
    {
        $this->addColumn(
            'message',
            'task_id',
            $this->integer()
        );

        $this->addForeignKey(
            'fk_message_task_id_column_to_message_table',
            \frontend\models\Message::tableName(),
            'task_id',
            \frontend\models\Task::tableName(),
            'id'
        );
    }

    /**
     * @note
     * Delete id column from table
     */
    public function safeDown(): void
    {
        $this->dropForeignKey(
            'fk_message_task_id_column_to_message_table',
            \frontend\models\Message::tableName()
        );

        $this->dropColumn(\frontend\models\Message::tableName(), 'task_id');
    }
}
