<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use app\models\Book;
use app\models\Author;

class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@'], // Доступно всем
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'], // Только авторизованные могут создавать
                    ],
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // Проверяем, может ли пользователь редактировать эту книгу
                            $id = Yii::$app->request->get('id');
                            $book = Book::findOne($id);
                            return $book && $book->canEdit();
                        }
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $books = Book::find()
            ->with('authors', 'creator')
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
        return $this->render('index', ['books' => $books]);
    }
    
    public function actionView($id)
    {
        $book = $this->findModel($id);
        return $this->render('view', ['book' => $book]);
    }
    
    public function actionCreate()
    {
        $book = new Book();
        $authors = Author::find()->orderBy('full_name')->all();
        
        if ($book->load(Yii::$app->request->post()) && $book->save()) {
            Yii::$app->session->setFlash('success', 'Книга успешно создана.');
            return $this->redirect(['view', 'id' => $book->id]);
        }
        
        return $this->render('create', [
            'book' => $book,
            'authors' => $authors,
        ]);
    }
    
    public function actionUpdate($id)
    {
        $book = $this->findModel($id);
        
        // Проверяем права
        if (!$book->canEdit()) {
            throw new ForbiddenHttpException('У вас нет прав для редактирования этой книги.');
        }
        
        $authors = Author::find()->orderBy('full_name')->all();
        
        if ($book->load(Yii::$app->request->post()) && $book->save()) {
            Yii::$app->session->setFlash('success', 'Книга успешно обновлена.');
            return $this->redirect(['view', 'id' => $book->id]);
        }
        
        return $this->render('update', [
            'book' => $book,
            'authors' => $authors,
        ]);
    }
    
    public function actionDelete($id)
    {
        $book = $this->findModel($id);
        
        // Проверяем права
        if (!$book->canEdit()) {
            throw new ForbiddenHttpException('У вас нет прав для удаления этой книги.');
        }
        
        $book->delete();
        Yii::$app->session->setFlash('success', 'Книга удалена.');
        return $this->redirect(['index']);
    }
    
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Книга не найдена.');
    }
}