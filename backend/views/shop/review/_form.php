<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\product\ReviewEditForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="review-form">


    <?php $form = ActiveForm::begin(); ?>

    <div class="box">
        <div class="box-body">
            <?= $form->field($model, 'vote')->dropDownList($model->voteList(), ['prompt' => ' -- Выбрать -- ']) ?>
            <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
