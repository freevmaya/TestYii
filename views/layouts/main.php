<?php
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f5f5f5; }
        .header { background: #333; color: white; padding: 15px 20px; }
        .header a { color: white; text-decoration: none; margin-right: 15px; }
        .header a:hover { text-decoration: underline; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .footer { background: #333; color: white; text-align: center; padding: 15px; margin-top: 50px; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 3px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .float-right { float: right; }
        .btn-link { background: none; border: none; color: white; cursor: pointer; text-decoration: underline; }
        .btn-link:hover { text-decoration: none; }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="header">
    <a href="/index.php?r=book/index">Книги</a>
    <a href="/index.php?r=author/index">Авторы</a>
    <a href="/index.php?r=report/index">ТОП-10 авторов</a>
    <?php if (Yii::$app->user->isGuest): ?>
        <a href="/index.php?r=site/login" style="float: right;">Вход</a>
    <?php else: ?>
        <span style="float: right;">
            <?= Yii::$app->user->identity->username ?>
            <?= Html::beginForm(['/site/logout'], 'post', ['style' => 'display: inline;']) ?>
                <?= Html::submitButton('Выйти', ['class' => 'btn-link']) ?>
            <?= Html::endForm() ?>
        </span>
    <?php endif; ?>
</div>

<div class="container">
    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
        <div class="alert alert-<?= $key ?>"><?= $message ?></div>
    <?php endforeach; ?>
    <?= $content ?>
</div>

<div class="footer">
    &copy; Каталог книг <?= date('Y') ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>