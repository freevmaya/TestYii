<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use app\models\Book;
use app\models\ReportForm;

class ReportController extends Controller
{
    public function actionIndex()
    {
        $model = new ReportForm();
        
        // Загружаем данные из GET-запроса
        $model->load(Yii::$app->request->get('ReportForm'), '');
        
        if (!$model->validate() || !$model->year) {
            $model->year = date('Y');
        }
        
        $year = $model->year;
        
        // Получаем доступные годы из базы
        $availableYears = Book::find()
            ->select('year')
            ->distinct()
            ->orderBy(['year' => SORT_DESC])
            ->column();
            
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

        return $this->render('index', [
            'model' => $model,
            'topAuthors' => $topAuthors,
            'year' => $year,
            'availableYears' => $availableYears,
        ]);
    }
}