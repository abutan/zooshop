<?php
/* @var $this \yii\web\View */
/* @var $reviewForm \store\forms\shop\ReviewForm */
/* @var $product null|\store\entities\shop\product\Product */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="review-form">
    <div id="review">
       <?php foreach ($product->reviews as $review): ?>
            <div class="product-review">
                <?= $review->text ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?php if ($review->user->username == null): ?>
                        Пользователь <?= $review->user_id ?>
                        <?php else: ?>
                        <?= $review->user->username ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-6 text-right">
                        <span style="font-style: italic;"><?=  Yii::$app->formatter->asDatetime($review->created_at) ?></span>
                    </div>
                </div>
            </div>
       <?php endforeach; ?>
    </div>

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