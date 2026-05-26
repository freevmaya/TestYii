<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Subscription;
use app\models\Author;

class SubscriptionController extends Controller
{
    
    public function actionSubscribe($authorId)
    {
        $author = Author::findOne($authorId);
        if (!$author) {
            throw new \yii\web\NotFoundHttpException('Автор не найден.');
        }
        
        $model = new Subscription();
        $model->author_id = $authorId;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Вы успешно подписались на автора "' . $author->full_name . '"');
            return $this->redirect(['author/view', 'id' => $authorId]);
        }
        
        return $this->render('subscribe', [
            'model' => $model,
            'author' => $author,
        ]);
    }
}