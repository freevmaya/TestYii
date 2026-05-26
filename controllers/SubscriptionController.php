<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Subscription;
use app\models\Author;

class SubscriptionController extends Controller
{
    public function actionSubscribe($authorId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $author = Author::findOne($authorId);
        if (!$author) {
            return ['success' => false, 'message' => 'Автор не найден.'];
        }
        
        $phone = Yii::$app->request->post('phone');
        if (!$phone) {
            return ['success' => false, 'message' => 'Введите номер телефона.'];
        }
        
        $subscription = new Subscription();
        $subscription->author_id = $authorId;
        $subscription->phone = $phone;
        
        if ($subscription->save()) {
            return ['success' => true, 'message' => 'Вы успешно подписались на автора.'];
        }
        
        $errors = $subscription->getFirstErrors();
        return ['success' => false, 'message' => reset($errors)];
    }
}