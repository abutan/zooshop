<?php

/* @var $this yii\web\View */
/* @var $model \store\forms\site\CommentEditForm */
/* @var $comment \store\entities\site\Comment */

$this->title = 'Редактирование комментария: ';
$this->params['breadcrumbs'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $comment->id, 'url' => ['view', 'id' => $comment->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="comment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
