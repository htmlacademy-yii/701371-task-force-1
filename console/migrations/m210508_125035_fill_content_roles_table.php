<?php

use yii\db\Migration;

/**
 * Class m210508_125035_fill_content_roles_table
 */
class m210508_125035_fill_content_roles_table extends Migration
{
    /**
     * @note
     * fill users_roles
     */
    public function safeUp(): void
    {
        /**
         * @note
         * users_roles
         */
        $this->batchInsert(\frontend\models\UsersRoles::tableName(),
            ['title', 'key_code'],
            [
                ['Исполнитель', 'executor'],
                ['Заказчик', 'customer'],
            ]
        );
    }

    /**
     * @note
     * clean users_roles
     */
    public function safeDown(): void
    {
        $this->delete(\frontend\models\UsersRoles::tableName());
    }
}
