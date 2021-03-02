<?php

use yii\db\Migration;

/**
 * Migration for add additional column with published_at to message table
 *
 * Class m201110_055547_add_published_at_column_to_message_table
 */
class m201110_055547_add_published_at_column_to_message_table extends Migration
{
    /**
     * Add id column to message table
     *
     * @return integer
     */
    public function safeUp()
    {
        $this->addColumn(
            'message',
            'published_at',
            $this->dateTime()
        );
    }

    /**
     * Delete id column from table
     *
     * @return integer
     */
    public function safeDown()
    {
        $this->dropColumn(\frontend\models\Message::tableName(), 'published_at');
    }
}
