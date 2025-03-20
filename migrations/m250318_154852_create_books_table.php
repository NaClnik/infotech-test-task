<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m250318_154852_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'book_id' => $this->primaryKey(),
            'book_name' => $this->string(64)->notNull(),
            'book_description' => $this->string(2048)->notNull(),
            'book_release_date' => $this->date()->notNull()
                ->comment('Дата выпуска книги'),
            'book_release_date_on_service' => $this->date()->notNull()->defaultExpression('CURRENT_DATE')
                ->comment('Дата выпуска книги в нашем сервисе.
                 Может быть такое, что книга ранее была опубликована на другом источнике'),
            'book_isbn' => $this->char(13)->notNull()->unique()
                ->comment('Международный стандартный книжный номер. Служит глобальным идентификатором для книги'),
            'book_photo_filename' => $this->string(64)->null()
                ->comment('Название файла, который содержит в себе фотографию книги'),
            'book_is_deleted' => $this->boolean()->notNull()->defaultValue(false),

            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }
}
