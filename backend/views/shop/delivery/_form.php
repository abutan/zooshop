<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \store\entities\shop\DeliveryMethod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-method-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cost')->textInput() ?>
            <?= $form->field($model, 'minPrice')->textInput() ?>
            <?= $form->field($model, 'maxPrice')->textInput() ?>
            <?= $form->field($model, 'minWeight')->textInput() ?>
            <?= $form->field($model, 'maxWeight')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
