<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Подписка на автора: ' . $author->full_name;
?>

<div class="subscription-form" style="max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <div style="margin: 20px 0; padding: 10px; background: #f5f5f5; border-radius: 5px;">
        <p><strong>Автор:</strong> <?= Html::encode($author->full_name) ?></p>
        <p>Подпишитесь на новые книги этого автора. Мы пришлём вам SMS-уведомление.</p>
    </div>
    
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'phone')->textInput([
        'maxlength' => true,
        'placeholder' => '+7 (900) 123-45-67'
    ]) ?>
    
    <div style="margin-top: 20px;">
        <?= Html::submitButton('Подписаться', ['class' => 'btn btn-success', 'style' => 'padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;']) ?>
        <?= Html::a('Отмена', ['author/view', 'id' => $author->id], ['class' => 'btn btn-default', 'style' => 'padding: 10px 20px; margin-left: 10px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>