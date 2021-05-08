<?php

use yii\db\Migration;

/**
 * Class m210507_061310_fill_content_category_table
 */
class m210507_061310_fill_content_category_table extends Migration
{
    /**
     * @note
     * fill category
     */
    public function safeUp(): void
    {
        /**
         * @note
         * category
         * fix import data for columns from data/sql/categories.sql
         */
        $this->batchInsert(\frontend\models\Category::tableName(),
            ['name', 'css_class'],
            [
                ['Курьерские услуги', 'translation'],
                ['Уборка', 'clean'],
                ['Переезды', 'cargo'],
                ['Компьютерная помощь', 'neo'],
                ['Ремонт квартирный', 'flat'],
                ['Ремонт техники', 'repair'],
                ['Красота', 'beauty'],
                ['Фото', 'photo'],
            ]
        );
    }

    /**
     * @note
     * clean category
     */
    public function safeDown(): void
    {
        $this->delete(\frontend\models\Category::tableName());
    }
}
