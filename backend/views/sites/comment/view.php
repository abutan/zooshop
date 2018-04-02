<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use store\helpers\CommentHelper;

/* @var $this yii\web\View */
/* @var $comment \store\entities\site\Comment */

$this->title = $comment->id;
$this->params['breadcrumbs'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-view">

    <p>
        <?php if ($comment->isActive()): ?>
        <?= Html::a('Отключить', ['draft', 'id' => $comment->id], ['class' => 'btn btn-danger', 'data-method' => 'post']) ?>
        <?php else: ?>
            <?= Html::a('Опубликовать', ['activate', 'id' => $comment->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>
        <?= Html::a('Редактировать', ['update', 'id' => $comment->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $comment->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $comment,
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => $comment->user->username ?: 'Пользователь ' . $comment->user->id,
            ],
            'text:ntext',
            'created_at:datetime',
            [
                'attribute' => 'status',
                'value' => CommentHelper::StatusLabel($comment->status),
                'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
