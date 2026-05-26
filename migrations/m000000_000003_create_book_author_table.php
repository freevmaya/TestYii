<?php

use yii\db\Migration;

class m000000_000003_create_book_author_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%book_author}}', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);
        
        $this->addPrimaryKey('pk-book_author', '{{%book_author}}', ['book_id', 'author_id']);

        $this->addForeignKey('fk-book_author-book_id', '{{%book_author}}', 'book_id', '{{%books}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-book_author-author_id', '{{%book_author}}', 'author_id', '{{%authors}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%book_author}}');
    }
}