<?php

use yii\db\Migration;

/**
 * Class m201225_052329_user_files_fill_table
 */
class m201225_052329_user_files_fill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            \frontend\models\UsersImage::tableName(),
            ['image_path', 'account_id'],
            [
                ['man-brune.jpg', 21],
                ['man-glasses.jpg', 21],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable(\frontend\models\UsersImage::tableName());
    }
}
