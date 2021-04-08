<?php

use yii\db\Migration;

/**
 * Class m201216_054625_fill_user_specialization_table
 */
class m201216_054625_fill_user_specialization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->batchInsert(
            \frontend\models\UserSpecialization::tableName(),
            ['user_id', 'category_id'],
            [
                // NOTE: is my user
                ['21', '5'],
                ['21', '2'],
                ['21', '3'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->delete(\frontend\models\UserSpecialization::tableName());
    }
}
