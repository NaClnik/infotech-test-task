<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscribers}}`.
 */
class m250319_143919_create_subscribers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscribers}}', [
            'subscriber_id' => $this->integer()->notNull()
                ->comment('Ссылка на подписчика'),
            'author_id' => $this->integer()->notNull()
                ->comment('Ссылка на автора, на которого подписывается пользователь')
        ]);

        $this->addForeignKey(
            'fk_subscribers_users_subscriber',
            '{{%subscribers}}',
            'subscriber_id',
            '{{%users}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk_subscribers_users_author',
            '{{%subscribers}}',
            'author_id',
            '{{%users}}',
            'user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscribers}}');
    }
}
