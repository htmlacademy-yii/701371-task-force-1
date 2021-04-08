<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_settings_specialization_id_to_user_specialization}}`.
 */
class m201126_213527_create_user_settings_specialization_id_to_user_specialization_table extends Migration
{
    /**
     * @note
     * create link
     */
    public function safeUp(): void
    {
        $this->addColumn(
            \frontend\models\Users::tableName(),
            'specialization_id',
            $this->integer());

        $this->addForeignKey(
            'fk_users_specialization_to_user_specialization_id',
            \frontend\models\Users::tableName(),
            'specialization_id',
            \frontend\models\UserSpecialization::tableName(),
            'id'
        );
    }

    /**
     * @note
     * drop link
     */
    public function safeDown(): void
    {
        $this->dropColumn(\frontend\models\Users::tableName(), 'specialization_id');

        $this->dropForeignKey(
            'fk_users_specialization_to_user_specialization_id',
            \frontend\models\forms\SettingsForm::tableName()
        );
    }
}
