<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\forms\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'parent_id') ?>

    <?= $form->field($model, 'body') ?>

    <?= $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'keywords') ?>

    <?php // echo $form->field($model, 'lft') ?>

    <?php // echo $form->field($model, 'rgt') ?>

    <?php // echo $form->field($model, 'depth') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
