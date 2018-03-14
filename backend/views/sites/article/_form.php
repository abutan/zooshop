<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\site\ArticleManageForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box">
        <div class="box-header with-border">Статья</div>
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'summary')->widget(CKEditor::class) ?>
            <?= $form->field($model, 'body')->widget(CKEditor::class) ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->hint('Не заполняйте это поле. При возникновении ошибок или замечаний, обратитесь к администратору.') ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">SEO</div>
        <div class="box-body">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
