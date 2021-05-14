<?php

use yii\db\Migration;

/**
 * Class m201208_195140_add_columns_to_notification
 */
class m201208_195140_add_columns_to_notification extends Migration
{
    /**
     * @note
     * add columns
     */
    public function safeUp(): void
    {
        $this->addColumn(
            \frontend\models\Notification::tableName(),
            'hidden_contacts',
            $this->boolean()
        );

        $this->addColumn(
            \frontend\models\Notification::tableName(),
            'hidden_profile',
            $this->boolean()
        );
    }

    /**
     * @note
     * drop columns
     */
    public function safeDown(): void
    {
        $this->dropColumn(\frontend\models\Notification::tableName(), 'hidden_contacts');
        $this->dropColumn(\frontend\models\Notification::tableName(), 'hidden_profile');
    }
}
