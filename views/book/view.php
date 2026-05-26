<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $book->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isUser = !Yii::$app->user->isGuest;
?>

<div class="book-view">
    <div class="row mb-3">
        <div class="col-md-8">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <?php if ($isUser): ?>
        <div class="col-md-4 text-right">
            <?= Html::a('Редактировать', ['update', 'id' => $book->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $book->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="row">
        <?php if ($book->cover_image): ?>
        <div class="col-md-4">
            <img src="<?= $book->cover_image ?>" class="img-fluid" alt="<?= Html::encode($book->title) ?>">
        </div>
        <div class="col-md-8">
        <?php else: ?>
        <div class="col-md-12">
        <?php endif; ?>
            <table class="table table-bordered">
                <tr>
                    <th style="width: 150px;">Название</th>
                    <td><?= Html::encode($book->title) ?></td>
                </tr>
                <tr>
                    <th>Год выпуска</th>
                    <td><?= $book->year ?></td>
                </tr>
                <tr>
                    <th>ISBN</th>
                    <td><?= $book->isbn ?: '—' ?></td>
                </tr>
                <tr>
                    <th>Авторы</th>
                    <td>
                        <?php 
                        $authors = [];
                        foreach ($book->authors as $author) {
                            $authors[] = Html::a(Html::encode($author->full_name), ['author/view', 'id' => $author->id]);
                        }
                        echo implode(', ', $authors);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Описание</th>
                    <td><?= nl2br(Html::encode($book->description)) ?></td>
                </tr>
                <tr>
                    <th>Дата добавления</th>
                    <td><?= Yii::$app->formatter->asDatetime($book->created_at) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>