<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%task}}`.
 */
class m200217_192138_add_owner_id_column_to_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            \frontend\models\Task::tableName(),
            'owner_id',
            $this->integer()->notNull()
        );

        // fk -> FOREIGN KEY
        //$this->addForeignKey(
        //    'fk_owner_id_user_id',
        //    \frontend\models\Task::tableName(),
        //    'owner_id',
        //    \frontend\models\Users::tableName(),
        //    'id'
        //);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\frontend\models\Task::tableName(),'owner_id');

        //$this->dropForeignKey(
        //    'fk_owner_id_user_id',
        //    \frontend\models\Task::tableName()
        //);
    }
}
