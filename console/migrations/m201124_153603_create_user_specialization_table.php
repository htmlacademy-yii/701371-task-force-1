<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_specializations}}`.
 */
class m201124_153603_create_user_specialization_table extends Migration
{
    /**
     * @note
     * create table and fields
     */
    public function safeUp(): void
    {
        $this->createTable('user_specialization', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(3)->notNull(),
            'category_id' => $this->integer(3)->notNull(),
        ], 'charset=utf8');
    }

    /**
     * @note
     * delete table and fields
     */
    public function safeDown(): void
    {
        $this->dropTable('user_specialization');
    }
}
