<?php

use yii\db\Migration;

/**
 * Class m201218_204009_user_specialization_fix_links
 */
class m201218_204009_user_notification_fix_links extends Migration
{
    public function safeUp()
    {
        $this->dropTable('notification');

        $this->createTable('user_notification', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'notification_type' => $this->tinyInteger()->unsigned()->notNull(),
            'active' => $this->tinyInteger(1)->notNull(),
        ], 'charset=utf8');

        $this->addForeignKey(
            'fk_users_notification_id_to_user_notification_id',
            'user_notification',
            'user_id',
            \frontend\models\Users::tableName(),
            'id',
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_users_notification_id_to_user_notification_id',
            \frontend\models\Notification::tableName()
        );

        $this->dropTable('user_notification');
    }
}
