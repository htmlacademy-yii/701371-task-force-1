<?php

use yii\db\Migration;

/**
 * Class m201207_194814_user_contacts_fill_data
 */
class m201207_194814_user_contacts_fill_data extends Migration
{
    public function safeUp(): void
    {
        /**
         * @note
         * add column & data & link
         */
        $this->addColumn(
            \frontend\models\UsersContacts::tableName(),
            'account_id',
            $this->integer(4),
        );

        $this->batchInsert(
            \frontend\models\UsersContacts::tableName(),
            ['phone', 'skype', 'messanger', 'account_id'],
            [
                [9996665544, 'skype1', 'messanger1', 21],
            ]
        );

        $this->addForeignKey(
            'fk_contacts_account_id_column_to_users_id',
            \frontend\models\UsersContacts::tableName(),
            'account_id',
            \frontend\models\Users::tableName(),
            'id'
        );
    }

    /**
     * @note
     * drop column & data & link
     */
    public function safeDown(): void
    {
        $this->dropForeignKey(
            'fk_contacts_account_id_column_to_users_id',
            \frontend\models\UsersContacts::tableName(),
        );

        $this->delete(\frontend\models\UsersContacts::tableName());

        $this->dropColumn(\frontend\models\UsersContacts::tableName(), 'account_id');
    }
}
