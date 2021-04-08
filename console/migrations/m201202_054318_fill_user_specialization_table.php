<?php

use yii\db\Migration;

/**
 * Class m201202_054318_fill_user_specialization_table
 */
class m201202_054318_fill_user_specialization_table extends Migration
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
                ['1', '1'],
                ['2', '2'],
                ['3', '3'],

                // NOTE: is my user
                ['21', '4'],
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
