<?php

use yii\db\Migration;

/**
 * Class m210103_210522_user_avatar_fix_table
 */
class m210103_210522_user_avatar_fix_table extends Migration
{
    public function safeUp()
    {
        $this->truncateTable(\frontend\models\UsersAvatar::tableName());

        $this->addColumn(
            \frontend\models\UsersAvatar::tableName(),
            'account_id',
            $this->integer()
        );

        $this->addForeignKey(
            'fk_user_avatar_to_user_id',
            \frontend\models\UsersAvatar::tableName(),
            'account_id',
            \frontend\models\Users::tableName(),
            'id'
        );

        // TODO: for local use - only one launch for fix errors links
        /*
        $this->dropForeignKey(
            'users_ibfk_4',
            \frontend\models\Users::tableName()
        );
        $this->dropIndex('avatar_id', \frontend\models\Users::tableName());
        */

        $this->batchInsert(
            \frontend\models\UsersAvatar::tableName(),
            ['image_path', 'account_id'],
            [
                ['man-blond.jpg', 20],
                ['man-glasses.jpg', 19],
                ['man-hat.jpg', 18],

                // TODO: for local use
                ['man-brune.jpg', 21],
            ]
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_user_avatar_to_user_id',
            \frontend\models\UsersAvatar::tableName()
        );

        $this->truncateTable(\frontend\models\UsersAvatar::tableName());

        $this->batchInsert(
            \frontend\models\UsersAvatar::tableName(),
            ['image_path'],
            [
                ['man-blond.jpg'],
                ['man-brune.jpg'],
                ['man-glasses.jpg'],
                ['man-hat.jpg'],
            ]
        );

        $this->dropColumn(\frontend\models\UsersAvatar::tableName(), 'account_id');

//        $this->addColumn(
//            \frontend\models\Users::tableName(),
//            'avatar_id',
//            $this->integer(11),
//        );
    }
}
