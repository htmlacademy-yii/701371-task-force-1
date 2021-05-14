<?php

use yii\db\Migration;

/**
 * Class m210430_191605_create_tables_for_project
 */
class m210430_191605_create_tables_for_project extends Migration
{
    /**
     * @note
     * create tables
     */
    public function safeUp(): void
    {
        /**
         * @note
         * create necessary tables
         */
        $this->createTable('auth', [
            'id' => $this->primaryKey()->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ], 'charset=utf8');

        $this->createTable('category', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string(32)->notNull(),
            'css_class' => $this->string(16)->notNull(),
        ], 'charset=utf8');

        $this->createTable('city', [
            'id' => $this->primaryKey()->notNull(),
            'title' => $this->string(32)->notNull(),
            'latitude' => $this->string(24)->notNull(),
            'longitude' => $this->string(24)->notNull(),
        ], 'charset=utf8');

        $this->createTable('message', [
            'id' => $this->primaryKey()->notNull(),
            'message' => $this->text()->notNull(),
            'sender_id' => $this->integer(11)->notNull(),
            'reciever_id' => $this->integer(11),
            'task_id' => $this->integer(11)->notNull(),
            'published_at' => $this->dateTime()->notNull()->defaultExpression('now()'),
        ], 'charset=utf8');

        $this->createTable('reviews', [
            'id' => $this->primaryKey()->notNull(),
            'description' => $this->text()->notNull(),
            'rating' => $this->float()->notNull(),
            'created' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'task_id' => $this->integer(11)->notNull(),
        ], 'charset=utf8');

        $this->createTable('task', [
            'id' => $this->primaryKey()->notNull(),
            'title' => $this->string(64)->notNull(),
            'description' => $this->text(),
            'address' => $this->string(255)->notNull(),
            'latitude' => $this->float()->notNull(),
            'longitude' => $this->float()->notNull(),
            'price' => $this->float()->notNull(),
            'deadline' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'created' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'city_id' => $this->integer(11),
            'executor_id' => $this->integer(11),
            'owner_id' => $this->integer(11)->notNull(),
            'status_id' => $this->integer(11)->notNull()->defaultValue(6),
            'category_id' => $this->integer(11)->notNull(),
        ], 'charset=utf8');

        $this->createTable('task_file', [
            'id' => $this->primaryKey()->notNull(),
            'image_path' => $this->string(45)->notNull(),
            'task_id' => $this->integer(11)->notNull(),
        ], 'charset=utf8');

        $this->createTable('task_respond', [
            'id' => $this->primaryKey()->notNull(),
            'comment' => $this->text()->notNull(),
            'price' => $this->float()->notNull(),
            'datetime' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'user_id' => $this->integer(11)->notNull(),
            'task_id' => $this->integer(11)->notNull(),
            'status_id' => $this->integer(11)->notNull(),
        ], 'charset=utf8');

        $this->createTable('task_status', [
            'id' => $this->primaryKey()->notNull(),
            'title' => $this->text()->notNull(),
        ], 'charset=utf8');

        $this->createTable('users', [
            'id' => $this->primaryKey()->notNull(),
            'email' => $this->string(64)->notNull(),
            'name' => $this->string(64)->notNull(),
            'password' => $this->string(64)->notNull(),
            'address' => $this->text()->notNull()->defaultValue(null),
            'born' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'created' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'about' => $this->text(),
            'visit' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'quest_completed' => $this->integer(4),
            'views_counter' => $this->integer(1),
            'hide_account' => $this->boolean()->notNull()->defaultValue(false),
            'city_id' => $this->integer(11),
            'auth_key' => $this->string(255),
            'password_reset_token' => $this->string(255),
        ], 'charset=utf8');

        $this->createTable('users_avatar', [
            'id' => $this->primaryKey()->notNull(),
            'image_path' => $this->string(45)->notNull(),
            'account_id' => $this->integer(11)->notNull(),
        ], 'charset=utf8');

        $this->createTable('users_category', [
            'id' => $this->primaryKey()->notNull(),
            'account_id' => $this->integer(11)->notNull(),
            'category_id' => $this->integer(11)->notNull(),
        ], 'charset=utf8');

        $this->createTable('users_contacts', [
            'id' => $this->primaryKey()->notNull(),
            'phone' => $this->string(11),
            'skype' => $this->string(64),
            'messanger' => $this->string(64),
            'account_id' => $this->integer(11)->notNull(),
        ], 'charset=utf8');

        $this->createTable('users_image', [
            'id' => $this->primaryKey()->notNull(),
            'image_path' => $this->string(64)->notNull(),
            'account_id' => $this->integer(11)->notNull(),
        ], 'charset=utf8');

        $this->createTable('users_roles', [
            'id' => $this->primaryKey()->notNull(),
            'title' => $this->string(32)->notNull(),
            'key_code' => $this->string(64)->notNull(),
        ], 'charset=utf8');

        $this->createTable('user_notification', [
            'id' => $this->primaryKey()->notNull(),
            'user_id' => $this->integer(3)->notNull(),
            'notification_type' => $this->integer(3)->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(false),
        ], 'charset=utf8');

        $this->createTable('user_specialization', [
            'id' => $this->primaryKey()->notNull(),
            'user_id' => $this->integer(3)->notNull(),
            'category_id' => $this->integer(3)->notNull(),
        ], 'charset=utf8');

        /* ----------------------------------------------------------------- */

        /**
         * @note
         * create index / key
         */

        /**
         * @note
         * auth table
         */
        $this->createIndex('index_category', 'auth', 'user_id');

        $this->addForeignKey('fk-auth-user_id-user-id', 'auth', 'user_id', 'users', 'id');

        /**
         * @note
         * category table
         */
        $this->createIndex('index_category', 'category', 'id');

        /**
         * @note
         * message table
         */
        $this->createIndex('sender_id', 'message', 'sender_id');
        $this->createIndex('reciever_id', 'message', 'reciever_id');
        $this->createIndex('fk_message_task_id_column_to_message_table', 'message', 'task_id');

        $this->addForeignKey('fk_message_task_id_column_to_message_table', 'message', 'task_id', 'task', 'id');
        $this->addForeignKey('message_ibfk_1', 'message', 'sender_id', 'users', 'id');
        $this->addForeignKey('message_ibfk_2', 'message', 'reciever_id', 'users', 'id');

        /**
         * @note
         * task table
         */
        $this->createIndex('category_id', 'task', 'category_id');
        $this->createIndex('executor_id', 'task', 'executor_id');
        $this->createIndex('owner_id', 'task', 'owner_id');
        $this->createIndex('status_id', 'task', 'status_id');
        $this->createIndex('city_id', 'task', 'city_id');

        $this->addForeignKey('task_ibfk_1', 'task', 'category_id', 'category', 'id');
        $this->addForeignKey('task_ibfk_2', 'task', 'executor_id', 'users', 'id');
        $this->addForeignKey('task_ibfk_3', 'task', 'owner_id', 'users', 'id');
        $this->addForeignKey('task_ibfk_4', 'task', 'status_id', 'task_status', 'id');
        $this->addForeignKey('task_ibfk_5', 'task', 'city_id', 'city', 'id');

        /**
         * @note
         * task_file table
         */
        $this->createIndex('task_id', 'task_file', 'task_id');

        $this->addForeignKey('task_file_ibfk_1', 'task_file', 'task_id', 'task', 'id');

        /**
         * @note
         * task_respond table
         */
        $this->createIndex('user_id', 'task_respond', 'user_id');
        $this->createIndex('task_id', 'task_respond', 'task_id');

        $this->addForeignKey('task_respond_ibfk_1', 'task_respond', 'user_id', 'users', 'id');
        $this->addForeignKey('task_respond_ibfk_2', 'task_respond', 'task_id', 'task', 'id');

        /**
         * @note
         * users table
         */
        $this->createIndex('city_id', 'users', 'city_id');

        $this->addForeignKey('users_ibfk_1', 'users', 'city_id', 'city', 'id');

        /**
         * @note
         * users_avatar table
         */
        $this->createIndex('fk_user_avatar_to_user_id', 'users_avatar', 'account_id');

        $this->addForeignKey('fk_user_avatar_to_user_id', 'users_avatar', 'account_id', 'users', 'id');

        /**
         * @note
         * users_category table
         */
        $this->createIndex('category_id', 'users_category', 'category_id');
        $this->createIndex('account_id', 'users_category', 'account_id');

        $this->addForeignKey('users_category_ibfk_1', 'users_category', 'category_id', 'category', 'id');
        $this->addForeignKey('users_category_ibfk_2', 'users_category', 'account_id', 'users', 'id');

        /**
         * @note
         * users_contacts table
         */
        $this->createIndex('fk_contacts_account_id_column_to_users_id', 'users_contacts', 'account_id');

        $this->addForeignKey('fk_contacts_account_id_column_to_users_id', 'users_contacts', 'account_id', 'users', 'id');

        /**
         * @note
         * users_image table
         */
        $this->createIndex('account_id', 'users_image', 'account_id');

        $this->addForeignKey('users_image_ibfk_1', 'users_image', 'account_id', 'users', 'id');

        /**
         * @note
         * user_notification table
         */
        $this->createIndex('fk_users_notification_id_to_user_notification_id', 'user_notification', 'user_id');

        $this->addForeignKey('fk_users_notification_id_to_user_notification_id', 'user_notification', 'user_id', 'users', 'id');

        /**
         * @note
         * user_specialization table
         */
        $this->createIndex('fk_user_specialization_to_user_specialization_id', 'user_specialization', 'user_id');
        $this->createIndex('fk_users_specialization_to_user_category_id', 'user_specialization', 'category_id');

        $this->addForeignKey('fk_user_specialization_to_user_specialization_id', 'user_notification', 'user_id', 'users', 'id');
    }

    /**
     * @note
     * drop all tables and links
     */
    public function safeDown(): void
    {
        /**
         * @note
         * drop key & index
         */

        $this->dropForeignKey('fk-auth-user_id-user-id', 'auth');
        $this->dropIndex('index_category', 'auth');

        $this->dropIndex('index_category', 'category');

        $this->dropForeignKey('fk_message_task_id_column_to_message_table', 'message');
        $this->dropForeignKey('message_ibfk_1', 'message');
        $this->dropForeignKey('message_ibfk_2', 'message');
        $this->dropIndex('sender_id', 'message');
        $this->dropIndex('reciever_id', 'message');
        $this->dropIndex('fk_message_task_id_column_to_message_table', 'message');

        $this->dropForeignKey('task_ibfk_1', 'task');
        $this->dropForeignKey('task_ibfk_2', 'task');
        $this->dropForeignKey('task_ibfk_3', 'task');
        $this->dropForeignKey('task_ibfk_4', 'task');
        $this->dropForeignKey('task_ibfk_5', 'task');
        $this->dropIndex('category_id', 'task');
        $this->dropIndex('executor_id', 'task');
        $this->dropIndex('owner_id', 'task');
        $this->dropIndex('status_id', 'task');
        $this->dropIndex('city_id', 'task');

        $this->dropForeignKey('task_file_ibfk_1', 'task_file');
        $this->dropIndex('task_id', 'task_file');

        $this->dropForeignKey('task_respond_ibfk_1', 'task_respond');
        $this->dropForeignKey('task_respond_ibfk_2', 'task_respond');
        $this->dropIndex('user_id', 'task_respond');
        $this->dropIndex('task_id', 'task_respond');

        $this->dropForeignKey('users_ibfk_1', 'users');
        $this->dropIndex('city_id', 'users');

        $this->dropForeignKey('fk_user_avatar_to_user_id', 'users_avatar');
        $this->dropIndex('fk_user_avatar_to_user_id', 'users_avatar');

        $this->dropForeignKey('users_category_ibfk_1', 'users_category');
        $this->dropForeignKey('users_category_ibfk_2', 'users_category');
        $this->dropIndex('category_id', 'users_category');
        $this->dropIndex('account_id', 'users_category');

        $this->dropForeignKey('fk_contacts_account_id_column_to_users_id', 'users_contacts');
        $this->dropIndex('fk_contacts_account_id_column_to_users_id', 'users_contacts');

        $this->dropForeignKey('users_image_ibfk_1', 'users_image');
        $this->dropIndex('account_id', 'users_image');

        $this->dropForeignKey('fk_users_notification_id_to_user_notification_id', 'user_notification');
        $this->dropForeignKey('fk_user_specialization_to_user_specialization_id', 'user_notification');
        $this->dropIndex('fk_users_notification_id_to_user_notification_id', 'user_notification');

        $this->dropIndex('fk_user_specialization_to_user_specialization_id', 'user_specialization');
        $this->dropIndex('fk_users_specialization_to_user_category_id', 'user_specialization');

        /**
         * @note
         * delete necessary tables
         */
        $this->dropTable('auth');
        $this->dropTable('category');
        $this->dropTable('city');
        $this->dropTable('message');
        $this->dropTable('reviews');
        $this->dropTable('task');
        $this->dropTable('task_file');
        $this->dropTable('task_respond');
        $this->dropTable('task_status');
        $this->dropTable('users');
        $this->dropTable('users_avatar');
        $this->dropTable('users_category');
        $this->dropTable('users_contacts');
        $this->dropTable('users_image');
        $this->dropTable('users_roles');
        $this->dropTable('user_notification');
        $this->dropTable('user_specialization');
    }
}
