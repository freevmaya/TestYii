<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="row">
        <div class="col-md-4">
            <?php $form = ActiveForm::begin(); ?>
            
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            
            <?= $form->field($model, 'password')->passwordInput() ?>
            
            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
            </div>
            
            <?php ActiveForm::end(); ?>
            
            <div class="alert alert-info mt-3">
                <strong>Тестовые данные:</strong><br>
                <div>
                    Логин: admin<br>
                    Пароль: admin
                </div>
                <hr>
                <div>
                    Логин: user<br>
                    Пароль: user
                </div>
            </div>
        </div>
    </div>
</div>