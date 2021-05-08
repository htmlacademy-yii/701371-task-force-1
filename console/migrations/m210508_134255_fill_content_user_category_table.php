<?php

use yii\db\Migration;

/**
 * Class m210508_134255_fill_content_user_category_table
 */
class m210508_134255_fill_content_user_category_table extends Migration
{
    /**
     * @note
     * fill user_category
     */
    public function safeUp(): void
    {
        /**
         * @note
         * task_respond
         */
        $this->batchInsert(\frontend\models\UsersCategory::tableName(),
            ['account_id', 'category_id'],
            [
                [1, 3],
                [2, 5],
                [3, 6],
                [4, 8],
            ]
        );
    }

    /**
     * @note
     * clean user_category
     */
    public function safeDown(): void
    {
        $this->delete(\frontend\models\UsersCategory::tableName());
    }
}
