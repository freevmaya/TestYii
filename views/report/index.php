<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'ТОП-10 авторов по количеству книг';
?>

<div class="report-index">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <!-- Форма выбора года - указываем явный URL -->
    <div style="margin: 20px 0; padding: 15px; background: #f5f5f5; border-radius: 5px;">
        <form method="get" action="/index.php?r=report/index" style="display: flex; gap: 10px; align-items: flex-end;">
            <div>
                <label for="year">Выберите год:</label>
                <select name="year" id="year" style="padding: 8px; border-radius: 4px; border: 1px solid #ddd;">
                    <?php foreach ($availableYears as $availableYear): ?>
                        <option value="<?= $availableYear ?>" <?= $availableYear == $year ? 'selected' : '' ?>>
                            <?= $availableYear ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <button type="submit" style="padding: 8px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Показать
                </button>
            </div>
        </form>
    </div>
    
    <!-- Результаты -->
    <?php if (empty($topAuthors)): ?>
        <div style="padding: 20px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 5px; color: #856404;">
            Нет данных за <?= Html::encode($year) ?> год.
        </div>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 10px; background: #f4f4f4;">#</th>
                    <th style="border: 1px solid #ddd; padding: 10px; background: #f4f4f4;">Автор</th>
                    <th style="border: 1px solid #ddd; padding: 10px; background: #f4f4f4;">Количество книг в <?= Html::encode($year) ?> году</th>
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
    <?php endif; ?>
</div>