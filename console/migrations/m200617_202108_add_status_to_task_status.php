<?php

use yii\db\Migration;

/**
 * Class m200617_202108_add_status_to_task_status
 */
class m200617_202108_add_status_to_task_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            \frontend\models\TaskStatus::tableName(),
            ['title'],
            [['work']]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(
            \frontend\models\TaskStatus::tableName(),
            ['in', 'title', ['work']]
        );
    }
}
