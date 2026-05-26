<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use app\models\Book;

class ReportController extends Controller
{
    public function actionIndex($year = null)
    {
        // Если год не указан, берём текущий
        if ($year === null) {
            $year = date('Y');
        }
        
        // Получаем доступные годы из базы
        $availableYears = Book::find()
            ->select('year')
            ->distinct()
            ->orderBy(['year' => SORT_DESC])
            ->column();
        
        // Если нет данных, показываем пустой массив
        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }
        
        // Запрос ТОП-10 авторов
        $query = (new Query())
            ->select([
                'a.id',
                'a.full_name',
                'COUNT(ba.book_id) as book_count',
            ])
            ->from('{{%authors}} a')
            ->innerJoin('{{%book_author}} ba', 'a.id = ba.author_id')
            ->innerJoin('{{%books}} b', 'ba.book_id = b.id')
            ->where(['b.year' => $year])
            ->groupBy('a.id')
            ->orderBy(['book_count' => SORT_DESC, 'a.full_name' => SORT_ASC])
            ->limit(10);
        
        $topAuthors = $query->all();
        
        // Рендерим представление
        return $this->render('index', [
            'topAuthors' => $topAuthors,
            'year' => $year,
            'availableYears' => $availableYears,
        ]);
    }
}