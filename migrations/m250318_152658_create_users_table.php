<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m250318_152658_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'user_id' => $this->primaryKey(),
            'user_email' => $this->string(128)->notNull()->unique(),
            'user_phone_number' => $this->char(11)->notNull()->unique(),
            'user_firstname' => $this->string(64)->notNull(),
            'user_lastname' => $this->string(64)->notNull(),
            'user_patronymic' => $this->string(64)->notNull(),
            'user_password_hash' => $this->string(128)->notNull()
                ->comment('Этот столбец нужен для хранения хэша пароля'),
            'user_auth_key' => $this->string(128)->notNull()
                ->comment('Этот столбец нужен для хранения ключа аутентификации.
                 Ключ аутентификации служит для того, чтобы пользователь мог аутентифицироваться по ключу,
                 который будет сохраняться локально в cookies у пользователя, а затем сравниваться тем, что хранится на сервере'),

            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
