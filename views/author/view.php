<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $author->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isUser = !Yii::$app->user->isGuest;
?>

<div class="author-view">
    <div class="row mb-3">
        <div class="col-md-8">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <?php if ($isUser): ?>
        <div class="col-md-4 text-right">
            <?= Html::a('Редактировать', ['update', 'id' => $author->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $author->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить этого автора?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Книги автора (<?= count($author->books) ?>):</h5>
                    <ul>
                        <?php foreach ($author->books as $book): ?>
                        <li><?= Html::a(Html::encode($book->title), ['book/view', 'id' => $book->id]) ?> (<?= $book->year ?>)</li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Кнопка подписки для гостей -->
    <?php if (Yii::$app->user->isGuest): ?>
    <div class="row mt-4">
        <div class="col-md-12">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#subscribeModal" data-author-id="<?= $author->id ?>" data-author-name="<?= Html::encode($author->full_name) ?>">
                Подписаться на новые книги этого автора
            </button>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal для подписки -->
<div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Подписка на автора</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Подпишитесь на новые книги автора <strong id="authorName"></strong></p>
                <div class="form-group">
                    <label for="phone">Номер телефона</label>
                    <input type="tel" class="form-control" id="phone" placeholder="+7 (XXX) XXX-XX-XX">
                    <small class="form-text text-muted">Мы отправим SMS-уведомление о новых книгах</small>
                </div>
                <div id="subscribeMessage"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary" id="subscribeBtn">Подписаться</button>
            </div>
        </div>
    </div>
</div>

<?php
$subscribeUrl = Url::to(['subscription/subscribe']);
$js = <<<JS
$('#subscribeModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var authorId = button.data('author-id');
    var authorName = button.data('author-name');
    
    var modal = $(this);
    modal.find('#authorName').text(authorName);
    modal.find('#subscribeBtn').data('author-id', authorId);
    modal.find('#phone').val('');
    modal.find('#subscribeMessage').html('');
});

$('#subscribeBtn').click(function() {
    var btn = $(this);
    var authorId = btn.data('author-id');
    var phone = $('#phone').val();
    var messageDiv = $('#subscribeMessage');
    
    btn.prop('disabled', true).text('Подписка...');
    
    $.ajax({
        url: '$subscribeUrl',
        type: 'POST',
        data: {authorId: authorId, phone: phone},
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                messageDiv.html('<div class="alert alert-success">' + response.message + '</div>');
                setTimeout(function() {
                    $('#subscribeModal').modal('hide');
                }, 2000);
            } else {
                messageDiv.html('<div class="alert alert-danger">' + response.message + '</div>');
                btn.prop('disabled', false).text('Подписаться');
            }
        },
        error: function() {
            messageDiv.html('<div class="alert alert-danger">Ошибка сервера. Попробуйте позже.</div>');
            btn.prop('disabled', false).text('Подписаться');
        }
    });
});
JS;

$this->registerJs($js);
?>