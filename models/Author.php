<?php

namespace app\models;

use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%authors}}';
    }
    
    public function rules()
    {
        return [
            [['full_name'], 'required'],
            [['full_name'], 'string', 'max' => 255],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'ФИО',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
    
    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('{{%book_author}}', ['author_id' => 'id']);
    }
    
    public function getSubscriptions()
    {
        return $this->hasMany(Subscription::class, ['author_id' => 'id']);
    }
}