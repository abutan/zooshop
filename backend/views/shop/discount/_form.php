<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\DiscountForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discount-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box">
        <div class="box-body">
            <?= $form->field($model, 'percent')->textInput() ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'fromDate')->widget(DatePicker::class, [
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd-M-yyyy',
                ]
            ]) ?>
            <?= $form->field($model, 'toDate')->widget(DatePicker::class, [
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd-M-yyyy',
                ]
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
