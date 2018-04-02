<?php

/* @var $item \frontend\widgets\site\CommentView */
/* @var $this \yii\web\View */
/* @var $user string */

?>

<div class="comment-item" id="comment<?= $item->comment->id ?>" data-id="<?= $item->comment->id ?>">
    <div class="panel panel-default">
        <div class="panel-body">
            <p class="comment-content">
                <?php if ($item->comment->isActive()): ?>
                <?= Yii::$app->formatter->asNtext($item->comment->text) ?>
                <?php else: ?>
                <strong><i>Сообщение не одобрено администратором.</i></strong>
                <?php endif; ?>
            </p>
            <div class="row">
                <div class="col-sm-3 text-left">
                    <?php if ($item->comment->user->username): ?>
                    <?= $item->comment->user->username ?>
                    <?php else: ?>
                    <?= 'Пользователь ' . $item->comment->user->id ?>
                    <?php endif; ?>
                </div>
                <div class="col-sm-4  text-right">
                    <?= Yii::$app->formatter->asDatetime($item->comment->created_at) ?>
                </div>
                <div class="col-sm-2 col-sm-offset-1">
                    <?php if (!Yii::$app->user->isGuest): ?>
                    <span class="comment-reply">Ответить</span>
                    <?php else: ?>
                    <span></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="margin">
        <div class="reply-block">
            <div class="comments">
                <?php foreach ($item->children as $children): ?>
                    <?= $this->render('_comment', ['item' => $children]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
