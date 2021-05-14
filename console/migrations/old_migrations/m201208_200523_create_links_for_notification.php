<?php

use yii\db\Migration;

/**
 * Class m201208_200523_create_links_for_notification
 */
class m201208_200523_create_links_for_notification extends Migration
{
    /**
     * @note
     * fill data
     */
    public function safeUp(): void
    {
        $this->batchInsert(
            \frontend\models\Notification::tableName(),
            ['new_messages', 'task_actions', 'new_responds', 'hidden_contacts', 'hidden_profile'],
            [
                [1, 1, 1, 0, 1],
                [1, 0, 0, 0, 0],
                [1, 1, 0, 0, 0],
            ]
        );

//        $this->addForeignKey(
//            'fk_notifications_to_user_id',
//            \frontend\models\Users::tableName(),
//            'notification_id',
//            \frontend\models\Notification::tableName(),
//            'id'
//        );
    }

    /**
     * @note
     * drop all data
     */
    public function safeDown(): void
    {
//        $this->dropForeignKey(
//            'fk_notifications_to_user_id',
//            \frontend\models\Users::tableName()
//        );

        $this->delete(\frontend\models\Notification::tableName());
    }
}
