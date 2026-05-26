<?php
use yii\helpers\Html;

$this->title = 'Редактировать автора: ' . $author->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $author->full_name, 'url' => ['view', 'id' => $author->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="author-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $author,
    ]) ?>
</div>