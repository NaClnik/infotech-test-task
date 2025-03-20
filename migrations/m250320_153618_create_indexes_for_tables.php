<?php

use yii\db\Migration;

class m250320_153618_create_indexes_for_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Сделал индекс по ISBN, т.к. потенциально будет очень много выборок книг с ISBN, хоть их сейчас и нет.
        $this->createIndex('books_book_isbn', '{{%books}}', 'book_isbn');

        // В приложении также нет выборки по email и phone_number, но потенциально их будет много, поэтому заранее сделал индекс.
        $this->createIndex('users_user_email', '{{%users}}', 'user_email');
        $this->createIndex('users_user_phone_number', '{{%users}}', 'user_phone_number');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('books_book_isbn', '{{%books}}');

        $this->dropIndex('users_user_email', '{{%users}}');
        $this->dropIndex('users_user_phone_number', '{{%users}}');
    }
}
