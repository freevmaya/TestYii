<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $author->full_name;

$isUser = !Yii::$app->user->isGuest;
?>

<style>
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f5f5f5; }
    .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
    .header { background: #333; color: white; padding: 15px; margin-bottom: 20px; }
    .header a { color: white; text-decoration: none; margin-right: 15px; }
    .card { background: white; border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
    .btn { display: inline-block; padding: 8px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 3px; border: none; cursor: pointer; }
    .btn-danger { background: #dc3545; }
    .btn-success { background: #28a745; }
    .btn-info { background: #17a2b8; }
    .alert { padding: 10px; margin-bottom: 15px; border-radius: 3px; }
    .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background: #f4f4f4; }
</style>

<div class="author-view">
    <div class="card">
        <h1><?= Html::encode($this->title) ?></h1>
        
        <?php if ($isUser): ?>
        <div style="margin-bottom: 20px;">
            <?= Html::a('Редактировать', ['update', 'id' => $author->id], ['class' => 'btn']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $author->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить этого автора?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <?php endif; ?>
        
        <h3>Книги автора (<?= count($author->books) ?>):</h3>
        <ul>
            <?php foreach ($author->books as $book): ?>
            <li><?= Html::a(Html::encode($book->title), ['book/view', 'id' => $book->id]) ?> (<?= $book->year ?>)</li>
            <?php endforeach; ?>
        </ul>
        
        <!-- Ссылка на подписку для гостей -->
        <?php if (Yii::$app->user->isGuest): ?>
        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 5px; text-align: center;">
            <p>Хотите получать уведомления о новых книгах этого автора?</p>
            <?= Html::a('Подписаться на новые книги', ['subscription/subscribe', 'authorId' => $author->id], ['class' => 'btn btn-info']) ?>
        </div>
        <?php endif; ?>
    </div>
</div>