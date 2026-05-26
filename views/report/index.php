<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'ТОП-10 авторов по количеству книг';
?>

<div class="report-index">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <!-- Форма выбора года -->
    <div style="margin: 20px 0; padding: 15px; background: #f5f5f5; border-radius: 5px;">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['report/index'],
            'options' => ['style' => 'display: flex; gap: 10px; align-items: flex-end;']
        ]); ?>
        
        <?= $form->field($model, 'year', [
            'options' => ['style' => 'margin-bottom: 0;'],
            'labelOptions' => ['style' => 'display: block; margin-bottom: 5px; font-weight: bold;'],
            'inputOptions' => [
                'style' => 'padding: 8px; border-radius: 4px; border: 1px solid #ddd;',
                'onchange' => 'this.form.submit()' // Автоматическая отправка при изменении
            ]
        ])->dropDownList(array_combine($availableYears, $availableYears), [
            'prompt' => 'Выберите год'
        ]) ?>
        
        <?php ActiveForm::end(); ?>
    </div>
    
    <!-- Результаты -->
    <?php if (empty($topAuthors)): ?>
        <div class="alert alert-info" style="padding: 20px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 5px; color: #856404;">
            Нет данных за <?= Html::encode($year) ?> год.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 10px; background: #f4f4f4;">#</th>
                        <th style="border: 1px solid #ddd; padding: 10px; background: #f4f4f4;">Автор</th>
                        <th style="border: 1px solid #ddd; padding: 10px; background: #f4f4f4;">Количество книг</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topAuthors as $index => $author): ?>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">
                            <strong><?= $index + 1 ?></strong>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 10px;">
                            <?= Html::a(Html::encode($author['full_name']), ['author/view', 'id' => $author['id']]) ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">
                            <?= $author['book_count'] ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 20px; padding: 10px; background: #e9ecef; border-radius: 5px; text-align: center;">
            <small>Показаны авторы, выпустившие больше всего книг в <?= Html::encode($year) ?> году</small>
        </div>
    <?php endif; ?>
</div>