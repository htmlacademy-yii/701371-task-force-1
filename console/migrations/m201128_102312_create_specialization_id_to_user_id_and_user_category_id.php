<?php

use yii\db\Migration;

/**
 * Class m201128_102312_create_specialization_id_to_user_id_and_user_category_id
 */
class m201128_102312_create_specialization_id_to_user_id_and_user_category_id extends Migration
{
    /**
     * @note
     * create link
     */
    public function safeUp(): void
    {
        $this->addForeignKey(
            'fk_user_specialization_to_user_specialization_id',
            \frontend\models\UserSpecialization::tableName(),
            'user_id',
            \frontend\models\Users::tableName(),
            'id'
        );

        $this->addForeignKey(
            'fk_users_specialization_to_user_category_id',
            \frontend\models\UserSpecialization::tableName(),
            'category_id',
            \frontend\models\Category::tableName(),
            'id'
        );
    }

    /**
     * @note
     * drop link
     */
    public function safeDown(): void
    {
        $this->dropForeignKey(
            'fk_user_specialization_to_user_specialization_id',
            \frontend\models\UserSpecialization::tableName()
        );

        $this->dropForeignKey(
            'fk_users_specialization_to_user_category_id',
            \frontend\models\UserSpecialization::tableName()
        );
    }
}
