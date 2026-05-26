<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'ТОП-10 авторов по количеству книг';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="report-index">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <form method="get" action="<?= Url::to(['index']) ?>" class="form-inline">
                <label class="mr-2">Год:</label>
                <select name="year" class="form-control mr-2">
                    <?php foreach ($availableYears as $availableYear): ?>
                        <option value="<?= $availableYear ?>" <?= $availableYear == $year ? 'selected' : '' ?>>
                            <?= $availableYear ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary">Показать</button>
            </form>
        </div>
    </div>
    
    <?php if (empty($topAuthors)): ?>
        <div class="alert alert-info">
            Нет данных за <?= Html::encode($year) ?> год.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Автор</th>
                        <th>Количество книг в <?= $year ?> году</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topAuthors as $index => $author): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <?= Html::a(Html::encode($author['full_name']), ['author/view', 'id' => $author['id']]) ?>
                        </td>
                        <td><?= $author['book_count'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>