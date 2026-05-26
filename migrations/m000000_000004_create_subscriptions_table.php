<?php

use yii\db\Migration;

class m000000_000004_create_subscriptions_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%subscriptions}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string(20)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        
        /* Пока не надо 
        $this->addForeignKey('fk-subscriptions-author_id', '{{%subscriptions}}', 'author_id', '{{%authors}}', 'id', 'CASCADE', 'CASCADE'); */
        $this->createIndex('idx-subscriptions-author_id', '{{%subscriptions}}', 'author_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%subscriptions}}');
    }
}