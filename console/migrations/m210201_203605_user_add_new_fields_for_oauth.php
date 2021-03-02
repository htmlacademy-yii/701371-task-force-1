<?php

use yii\db\Migration;

/**
 * @note
 * for task 18 - socialization
 * chapter: 9,1
 *
 * Class m210201_203605_user_add_new_fields_for_oauth
 */
class m210201_203605_user_add_new_fields_for_oauth extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            \frontend\models\Users::tableName(),
            'auth_key',
            $this->string()
        );

        $this->addColumn(
            \frontend\models\Users::tableName(),
            'password_reset_token',
            $this->string()
        );

        $this->addColumn(
            \frontend\models\Users::tableName(),
            'status',
            $this->string()
        );

        $this->createTable('auth', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);

        $this->addForeignKey('fk-auth-user_id-user-id', 'auth', 'user_id', \frontend\models\Users::tableName(), 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropColumn(\frontend\models\Users::tableName(), 'auth_key');
        $this->dropColumn(\frontend\models\Users::tableName(), 'password_reset_token');
        $this->dropColumn(\frontend\models\Users::tableName(), 'status');

        $this->dropTable('auth');
    }
}
