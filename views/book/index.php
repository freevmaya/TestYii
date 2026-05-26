<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Каталог книг';
$this->params['breadcrumbs'][] = $this->title;

$isUser = !Yii::$app->user->isGuest;
?>

<div class="book-index">
    <div class="row mb-3">
        <div class="col-md-6">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <?php if ($isUser): ?>
        <div class="col-md-6 text-right">
            <?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="row">
        <?php foreach ($books as $book): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <?php if ($book->cover_image): ?>
                    <img src="<?= $book->cover_image ?>" class="card-img-top" alt="<?= Html::encode($book->title) ?>" style="height: 300px; object-fit: cover;">
                <?php else: ?>
                    <div class="card-img-top bg-secondary text-white text-center py-5" style="height: 300px;">
                        <p class="mt-5">Нет обложки</p>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?= Html::encode($book->title) ?></h5>
                    <p class="card-text">
                        <strong>Год:</strong> <?= $book->year ?><br>
                        <strong>ISBN:</strong> <?= $book->isbn ?: '—' ?><br>
                        <strong>Авторы:</strong> 
                        <?php 
                        $authors = [];
                        foreach ($book->authors as $author) {
                            $authors[] = Html::a(Html::encode($author->full_name), ['author/view', 'id' => $author->id]);
                        }
                        echo implode(', ', $authors);
                        ?>
                    </p>
                    <?= Html::a('Подробнее', ['view', 'id' => $book->id], ['class' => 'btn btn-primary']) ?>
                </div>
                <div class="card-footer">
                    <?= Html::a('Подробнее', ['view', 'id' => $book->id], ['class' => 'btn btn-primary btn-sm']) ?>
                    
                    <?php if ($book->canEdit()): ?>
                        <?= Html::a('Редактировать', ['update', 'id' => $book->id], ['class' => 'btn btn-warning btn-sm']) ?>
                        <?= Html::a('Удалить', ['delete', 'id' => $book->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    <?php endif; ?>
                    
                    <?php if (!Yii::$app->user->isGuest && !$book->canEdit()): ?>
                        <small class="text-muted">(Создатель: <?= Html::encode($book->creator->username ?? 'Неизвестен') ?>)</small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>