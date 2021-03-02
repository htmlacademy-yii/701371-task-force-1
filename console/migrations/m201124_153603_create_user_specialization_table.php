<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_specializations}}`.
 */
class m201124_153603_create_user_specialization_table extends Migration
{
    /**
     * create table and fields
     *
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('user_specialization', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(3)->notNull(),
            'category_id' => $this->integer(3)->notNull(),
        ], 'charset=utf8');
    }

    /**
     * delete table and fields
     *
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable('user_specialization');
    }
}
