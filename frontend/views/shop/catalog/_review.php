<?php
/* @var $this \yii\web\View */
/* @var $reviewForm \store\forms\shop\ReviewForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="review-form">
    <h2>Оставьте свой отзыв</h2>

    <?php if (Yii::$app->user->isGuest): ?>
    <p>
        Вам необходимо <a href="<?= Url::to(['/auth/signup/request']) ?>" target="_blank">зарегистрироваться</a>  или <a href="<?= Url::to(['/auth/auth/login']) ?>" target="_blank">войти</a>  на сайт чтобы оставить свой отзыв
    </p>
    <?php else: ?>
    <?php $form = ActiveForm::begin(['id' => 'form-review']) ?>

    <?= $form->field($reviewForm, 'vote')->dropDownList($reviewForm->voteList(), ['prompt' => '-- Оценить --']) ?>

    <?= $form->field($reviewForm, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Оставить отзыв', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

    <?php endif; ?>
</div>