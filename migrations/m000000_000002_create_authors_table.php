<?php

use yii\db\Migration;

class m000000_000002_create_authors_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(255)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
        
        $this->createIndex('idx-authors-full_name', '{{%authors}}', 'full_name');
    }

    public function safeDown()
    {
        $this->dropTable('{{%authors}}');
    }
}