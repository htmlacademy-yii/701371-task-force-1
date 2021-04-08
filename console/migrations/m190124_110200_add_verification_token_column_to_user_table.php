<?php

use \yii\db\Migration;

class m190124_110200_add_verification_token_column_to_user_table extends Migration
{
    /**
     * @note
     * add column
     */
    public function up(): void
    {
        $this->addColumn('{{%user}}', 'verification_token', $this->string()->defaultValue(null));
    }

    /**
     * @note
     * drop column
     */
    public function down(): void
    {
        $this->dropColumn('{{%user}}', 'verification_token');
    }
}
