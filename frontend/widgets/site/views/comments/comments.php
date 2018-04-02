<?php

/* @var $this \yii\web\View */
/* @var $model \store\forms\site\CommentForm */
/* @var $items array */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>

<div class="inner-bottom" id="comments">
    <h3>Предложения (вопросы, сообщения, объявления)</h3>

    <?php foreach ($items as $item): ?>
        <?= $this->render('_comment', ['item' => $item]) ?>
    <?php endforeach; ?>
</div>

<div class="leave-reply" id="reply-block">
    <?php $form = ActiveForm::begin() ?>
    <?= Html::activeHiddenInput($model, 'parentId') ?>
    <?= $form->field($model, 'text')->textarea(['rows' => 3]) ?>
    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>


