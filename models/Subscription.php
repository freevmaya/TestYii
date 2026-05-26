<?php

namespace app\models;

use yii\db\ActiveRecord;

class Subscription extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%subscriptions}}';
    }
    
    public function rules()
    {
        return [
            [['author_id', 'phone'], 'required'],
            [['author_id'], 'integer'],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'match', 'pattern' => '/^[\+\d\s\-\(\)]+$/', 'message' => 'Введите корректный номер телефона'],
            [['author_id', 'phone'], 'unique', 'targetAttribute' => ['author_id', 'phone'], 'message' => 'Вы уже подписаны на этого автора'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'phone' => 'Номер телефона',
            'created_at' => 'Дата подписки',
        ];
    }
    
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}