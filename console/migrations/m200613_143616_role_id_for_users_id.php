<?php

use yii\db\Migration;

/**
 * Class m200613_143616_role_id_for_users_id
 */
class m200613_143616_role_id_for_users_id extends Migration
{
    /**
     * @note
     * add columns
     */
    public function safeUp(): void
    {
        // NOTE: for the first use of migration
        /*
        $this->dropForeignKey(
            'users_ibfk_5',
            \frontend\models\Users::tableName()
        );
        */


        $this->dropColumn(\frontend\models\Users::tableName(), 'role_id');

        $this->addColumn(
            \frontend\models\Users::tableName(),
            'role_id',
            $this->integer()->notNull()->defaultValue('2')
        );

        $this->addForeignKey(
            'fk_users_role_id_to_users_roles_id',
            \frontend\models\Users::tableName(),
            'role_id',
            \frontend\models\UsersRoles::tableName(),
            'id'
        );
    }

    /**
     * @note
     * drop columns to default
     *
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropColumn(\frontend\models\Users::tableName(), 'role_id');

        $this->addColumn(
            \frontend\models\Users::tableName(),
            'role_id',
            $this->tinyInteger()
        );

        $this->dropForeignKey(
            'fk_users_role_id_to_users_roles_id',
            \frontend\models\Users::tableName()
        );
    }
}
