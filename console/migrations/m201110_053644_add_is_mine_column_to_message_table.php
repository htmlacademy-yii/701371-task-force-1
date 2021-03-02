<?php

use yii\db\Migration;

/**
 * Migration for add additional column with is_mine to message table
 *
 * Class m201110_053644_add_is_mine_column_to_message_table
 */
class m201110_053644_add_is_mine_column_to_message_table extends Migration
{
    /**
     * Add id column to message table
     *
     * @return bool
     */
    public function safeUp()
    {
//        $this->addColumn(
//            'message',
//            'is_mine',
//            $this->boolean()->notNull()->defaultValue(false)
//        );
    }

    /**
     * Delete id column from table
     *
     * @return bool
     */
    public function safeDown()
    {
//        $this->dropColumn(\frontend\models\Message::tableName(), 'is_mine');
    }
}
