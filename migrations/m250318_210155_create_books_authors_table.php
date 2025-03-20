<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books_authors}}`.
 */
class m250318_210155_create_books_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books_authors}}', [
            'author_id' => $this->integer()->notNull()
                ->comment('Ссылка на user_id, который является автором книги'),
            'book_id' => $this->integer()->notNull(),

            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey(
            'fk_books_authors_users',
            '{{%books_authors}}',
            'author_id',
            '{{%users}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk_books_authors_books',
            '{{%books_authors}}',
            'book_id',
            '{{%books}}',
            'book_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books_authors}}');
    }
}
