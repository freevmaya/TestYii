<?php

use yii\db\Migration;

class m000000_000001_create_books_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'created_by' => $this->integer()->defaultValue(0),
            'title' => $this->string(255)->notNull(),
            'year' => $this->integer(4)->notNull(),
            'description' => $this->text(),
            'isbn' => $this->string(20)->unique(),
            'cover_image' => $this->string(255),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }
}