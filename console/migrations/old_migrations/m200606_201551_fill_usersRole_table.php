<?php

use yii\db\Migration;

/**
 * Class m200606_201551_fill_usersRole_table
 */
class m200606_201551_fill_usersRole_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {

        $this->batchInsert(
            \frontend\models\UsersRoles::tableName(),
            ['title', 'key_code'],
            [
                ['Исполнитель', 'executor'],
                ['Заказчик', 'customer'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->truncateTable(\frontend\models\UsersRoles::tableName());
    }
}
