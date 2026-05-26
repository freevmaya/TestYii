<?php

use yii\db\Migration;

class m000000_000006_seed_test_data extends Migration
{
    public function safeUp()
    {
        // Массив реальных авторов
        $authors = [
            'Лев Толстой',
            'Фёдор Достоевский',
            'Антон Чехов',
            'Иван Тургенев',
            'Михаил Булгаков',
            'Александр Пушкин',
            'Николай Гоголь',
            'Иван Бунин',
            'Александр Солженицын',
            'Борис Пастернак',
        ];
        
        // Вставляем авторов
        $authorIds = [];
        foreach ($authors as $authorName) {
            $this->insert('{{%authors}}', [
                'full_name' => $authorName,
                'created_at' => date('Y-m-d H:i:s', strtotime('-' . rand(1, 365) . ' days')),
            ]);
            $authorIds[] = $this->db->getLastInsertID();
        }
        
        // Массив книг с реальными названиями
        $booksData = [
            ['title' => 'Война и мир', 'year' => 1869, 'description' => 'Роман-эпопея о событиях наполеоновских войн.'],
            ['title' => 'Анна Каренина', 'year' => 1877, 'description' => 'Трагическая история любви замужней дамы.'],
            ['title' => 'Преступление и наказание', 'year' => 1866, 'description' => 'Роман о моральных дилеммах и наказании.'],
            ['title' => 'Братья Карамазовы', 'year' => 1880, 'description' => 'Философский роман о вере и сомнении.'],
            ['title' => 'Идиот', 'year' => 1869, 'description' => 'Роман о "положительно прекрасном человеке".'],
            ['title' => 'Вишнёвый сад', 'year' => 1904, 'description' => 'Пьеса о судьбе дворянского имения.'],
            ['title' => 'Чайка', 'year' => 1896, 'description' => 'Пьеса о творчестве и любви.'],
            ['title' => 'Отцы и дети', 'year' => 1862, 'description' => 'Роман о конфликте поколений.'],
            ['title' => 'Дворянское гнездо', 'year' => 1859, 'description' => 'Роман о дворянской семье.'],
            ['title' => 'Мастер и Маргарита', 'year' => 1967, 'description' => 'Мистический роман о любви и силе искусства.'],
            ['title' => 'Собачье сердце', 'year' => 1925, 'description' => 'Повесть об эксперименте по превращению собаки в человека.'],
            ['title' => 'Евгений Онегин', 'year' => 1833, 'description' => 'Роман в стихах о судьбе "лишнего человека".'],
            ['title' => 'Капитанская дочка', 'year' => 1836, 'description' => 'Исторический роман о пугачёвском бунте.'],
            ['title' => 'Мёртвые души', 'year' => 1842, 'description' => 'Поэма о мошеннике, скупающем мёртвых крестьян.'],
            ['title' => 'Ревизор', 'year' => 1836, 'description' => 'Комедия о чиновниках и мнимом ревизоре.'],
            ['title' => 'Тёмные аллеи', 'year' => 1943, 'description' => 'Сборник рассказов о любви.'],
            ['title' => 'Жизнь Арсеньева', 'year' => 1930, 'description' => 'Автобиографический роман.'],
            ['title' => 'Один день Ивана Денисовича', 'year' => 1962, 'description' => 'Повесть о жизни в советском лагере.'],
            ['title' => 'Матрёнин двор', 'year' => 1963, 'description' => 'Рассказ о русской женщине.'],
            ['title' => 'Доктор Живаго', 'year' => 1957, 'description' => 'Роман о судьбе интеллигенции в революции.'],
        ];
        
        // Массив заглушек для обложек
        $coverImages = [
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
            'https://www.centrmag.ru/catalog/ev_27_5_22_2_3d.jpg',
        ];
        
        // Вставляем книги
        $bookIds = [];
        for ($i = 0; $i < count($booksData); $i++) {
            $book = $booksData[$i];
            $coverImage = $coverImages[$i];
            
            // Генерируем короткий ISBN (максимум 13 символов)
            $isbn = '978-5-17-' . str_pad(rand(1000, 99999), 5, '0', STR_PAD_LEFT);
            
            $this->insert('{{%books}}', [
                'title' => $book['title'],
                'year' => $book['year'],
                'description' => $book['description'] . ' Классическое произведение русской литературы.',
                'isbn' => $isbn,
                'cover_image' => $coverImage,
                'created_at' => date('Y-m-d H:i:s', strtotime('-' . rand(0, 30) . ' days')),
            ]);
            $bookIds[] = $this->db->getLastInsertID();
        }
        
        // Связываем книги с авторами (от 1 до 3 авторов на книгу)
        for ($i = 0; $i < count($bookIds); $i++) {
            $bookId = $bookIds[$i];
            // Случайное количество авторов от 1 до 3
            $numAuthors = rand(1, 3);
            
            // Перемешиваем массив авторов и берём первые $numAuthors
            $shuffledAuthors = $authorIds;
            shuffle($shuffledAuthors);
            $selectedAuthors = array_slice($shuffledAuthors, 0, $numAuthors);
            
            foreach ($selectedAuthors as $authorId) {
                $this->insert('{{%book_author}}', [
                    'book_id' => $bookId,
                    'author_id' => $authorId,
                ]);
            }
        }
        
        // Добавляем несколько подписок для теста
        $testPhones = [
            '+79991234567',
            '+79992345678',
            '+79993456789',
            '+79994567890',
            '+79995678901',
        ];
        
        for ($i = 0; $i < min(5, count($authorIds)); $i++) {
            $this->insert('{{%subscriptions}}', [
                'author_id' => $authorIds[$i],
                'phone' => $testPhones[$i],
                'created_at' => date('Y-m-d H:i:s', strtotime('-' . rand(1, 10) . ' days')),
            ]);
        }
    }
    
    public function safeDown()
    {
        // Очищаем все тестовые данные
        $this->truncateTable('{{%book_author}}');
        $this->truncateTable('{{%subscriptions}}');
        $this->truncateTable('{{%books}}');
        $this->truncateTable('{{%authors}}');
    }
}