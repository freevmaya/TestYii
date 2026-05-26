<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$isUser = !Yii::$app->user->isGuest;
?>

<div class="book-form">
    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'year')->textInput(['type' => 'number', 'min' => 1000, 'max' => date('Y')]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'isbn')->textInput(['maxlength' => 13]) ?>
        </div>
    </div>
    
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    
    <?php if ($isUser && isset($authors)): ?>
    <div class="form-group">
        <?= Html::activeLabel($model, 'authorIds', ['label' => 'Авторы']) ?>
        <?= Html::activeCheckboxList($model, 'authorIds', 
            ArrayHelper::map($authors, 'id', 'full_name'),
            [
                'class' => 'checkbox-list',
                'itemOptions' => ['labelOptions' => ['style' => 'margin-right: 15px;']],
                'separator' => '<br>',
            ]
        ) ?>
    </div>
    <?php endif; ?>
    
    <?= $form->field($model, 'cover_image')->textInput([
        'placeholder' => 'https://example.com/cover.jpg',
        'maxlength' => 500
    ]) ?>
    <div class="help-block">Введите прямой URL изображения обложки книги</div>
    
    <?php if ($model->cover_image && !$model->isNewRecord): ?>
    <div class="form-group">
        <label>Текущая обложка</label><br>
        <img src="<?= $model->cover_image ?>" style="max-width: 200px; border: 1px solid #ddd; padding: 5px;" 
             onerror="this.src='https://via.placeholder.com/200x280/cccccc/666666?text=No+Image'">
    </div>
    <?php endif; ?>
    
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>