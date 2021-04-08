<?php

use yii\db\Migration;

/**
 * Class m200715_053235_add_task_status_new_status
 */
class m200715_053235_add_task_status_new_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {

        $this->batchInsert(
            \frontend\models\TaskStatus::tableName(),
            ['title'],
            [
                ['new']
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->truncateTable(\frontend\models\TaskStatus::tableName());

        $this->batchInsert(
            \frontend\models\TaskStatus::tableName(),
            ['title'],
            [
                ['respond'],
                ['cancel'],
                ['completed'],
                ['fail'],
                ['work'],
            ]
        );
    }
}
