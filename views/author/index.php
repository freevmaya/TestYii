<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;

$isUser = !Yii::$app->user->isGuest;
?>

<div class="author-index">
    <div class="row mb-3">
        <div class="col-md-6">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <?php if ($isUser): ?>
        <div class="col-md-6 text-right">
            <?= Html::a('Добавить автора', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ФИО</th>
                    <th>Количество книг</th>
                    <th>Дата создания</th>
                    <?php if ($isUser): ?>
                    <th>Действия</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($authors as $author): ?>
                <tr>
                    <td><?= $author->id ?></td>
                    <td>
                        <?= Html::a(Html::encode($author->full_name), ['view', 'id' => $author->id]) ?>
                    </td>
                    <td><?= count($author->books) ?></td>
                    <td><?= Yii::$app->formatter->asDate($author->created_at) ?></td>
                    <?php if ($isUser): ?>
                    <td>
                        <?= Html::a('Просмотр', ['view', 'id' => $author->id], ['class' => 'btn btn-info btn-sm']) ?>
                        <?= Html::a('Редактировать', ['update', 'id' => $author->id], ['class' => 'btn btn-warning btn-sm']) ?>
                        <?= Html::a('Удалить', ['delete', 'id' => $author->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Вы уверены?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>