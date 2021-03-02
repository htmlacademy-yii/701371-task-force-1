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
     * Add id column to message table
     *
     * @return bool|void
     */
    public function safeUp()
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
     * Delete id column from table
     *
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_message_task_id_column_to_message_table',
            \frontend\models\Message::tableName()
        );

        $this->dropColumn(\frontend\models\Message::tableName(), 'task_id');
    }
}
