<?php

use yii\db\Migration;

class m000000_000005_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull()->unique(),
            'password_hash' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        
        // Создаём тестового пользователя (username: admin, password: admin)
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'auth_key' => Yii::$app->security->generateRandomString(),
        ]);

        $this->insert('{{%user}}', [
            'username' => 'user',
            'password_hash' => Yii::$app->security->generatePasswordHash('user'),
            'auth_key' => Yii::$app->security->generateRandomString(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}