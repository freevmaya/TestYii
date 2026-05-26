<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    public $authorIds = [];
    
    public static function tableName()
    {
        return '{{%books}}';
    }
    
    public function rules()
    {
        return [
            [['title', 'year'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['year'], 'integer', 'min' => 1000, 'max' => date('Y')],
            [['description'], 'string'],
            [['isbn'], 'string', 'max' => 13],
            [['isbn'], 'unique'],
            [['cover_image'], 'url', 'message' => 'Введите корректный URL изображения'],
            [['cover_image'], 'string', 'max' => 500],
            [['authorIds'], 'each', 'rule' => ['integer']],
            [['created_by'], 'integer'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'cover_image' => 'URL обложки',
            'authorIds' => 'Авторы',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'created_by' => 'Создатель',
        ];
    }
    
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('{{%book_author}}', ['book_id' => 'id']);
    }
    
    // Связь с пользователем-создателем
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
    
    // Проверка, может ли пользователь редактировать книгу
    public function canEdit()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        
        // Администратор (id=1) может редактировать всё
        if (Yii::$app->user->id == 1) {
            return true;
        }
        
        // Обычный пользователь может редактировать только свои книги
        return $this->created_by == Yii::$app->user->id;
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                // При создании книги устанавливаем текущего пользователя как создателя
                $this->created_by = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }
    
    public function afterFind()
    {
        parent::afterFind();
        $this->authorIds = $this->getAuthors()->select('id')->column();
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        // Обновляем связи с авторами
        BookAuthor::deleteAll(['book_id' => $this->id]);
        
        if (!empty($this->authorIds)) {
            foreach ($this->authorIds as $authorId) {
                $bookAuthor = new BookAuthor();
                $bookAuthor->book_id = $this->id;
                $bookAuthor->author_id = $authorId;
                $bookAuthor->save();
            }
        }
        
        // Отправляем SMS подписчикам при создании новой книги
        if ($insert) {
            $this->sendNotificationsToSubscribers();
        }
    }
    
    private function sendNotificationsToSubscribers()
    {
        $phones = [];
        
        foreach ($this->authors as $author) {
            $subscriptions = Subscription::find()->where(['author_id' => $author->id])->all();
            foreach ($subscriptions as $subscription) {
                if (!in_array($subscription->phone, $phones)) {
                    $phones[] = $subscription->phone;
                }
            }
        }
        
        if (!empty($phones)) {
            $message = "Новая книга: \"{$this->title}\" ({$this->year}) от автора(ов): " . implode(', ', $this->getAuthors()->select('full_name')->column());
            
            $smsComponent = new \app\components\SmsPilot();
            foreach ($phones as $phone) {
                $smsComponent->send($phone, $message);
            }
        }
    }
}