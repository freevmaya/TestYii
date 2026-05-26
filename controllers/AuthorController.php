<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\models\Author;
use app\models\Book;

class AuthorController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $authors = Author::find()->orderBy('full_name')->all();
        return $this->render('index', ['authors' => $authors]);
    }
    
    public function actionView($id)
    {
        $author = $this->findModel($id);
        return $this->render('view', ['author' => $author]);
    }
    
    public function actionCreate()
    {
        $author = new Author();
        
        if ($author->load(Yii::$app->request->post()) && $author->save()) {
            Yii::$app->session->setFlash('success', 'Автор успешно создан.');
            return $this->redirect(['view', 'id' => $author->id]);
        }
        
        return $this->render('create', ['author' => $author]);
    }
    
    public function actionUpdate($id)
    {
        $author = $this->findModel($id);
        
        if ($author->load(Yii::$app->request->post()) && $author->save()) {
            Yii::$app->session->setFlash('success', 'Автор успешно обновлён.');
            return $this->redirect(['view', 'id' => $author->id]);
        }
        
        return $this->render('update', ['author' => $author]);
    }
    
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Автор удалён.');
        return $this->redirect(['index']);
    }
    
    protected function findModel($id)
    {
        if (($model = Author::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Автор не найден.');
    }
}