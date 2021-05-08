<?php

use yii\db\Migration;

/**
 * Class m210508_132829_fill_content_message_table
 */
class m210508_132829_fill_content_message_table extends Migration
{
    /**
     * @note
     * fill messages
     */
    public function safeUp(): void
    {
        /**
         * @note
         * users_roles
         */
        $this->batchInsert(\frontend\models\Message::tableName(),
            ['message', 'sender_id', 'reciever_id', 'task_id'],
            [
                ['there is no cow level', 1, 2, 1],
                ['there is no cow level', 2, 1, 1],

                ['there is no cow level', 3, 4, 2],
                ['there is no cow level', 4, 3, 2],

                ['there is no cow level', 5, 6, 3],
                ['there is no cow level', 6, 5, 3],

                ['there is no cow level', 7, 8, 4],
                ['there is no cow level', 8, 7, 4],

                ['there is no cow level', 9, 10, 5],
                ['there is no cow level', 10, 9, 5],
            ]
        );
    }

    /**
     * @note
     * clean messages
     */
    public function safeDown(): void
    {
        $this->delete(\frontend\models\Message::tableName());
    }
}
