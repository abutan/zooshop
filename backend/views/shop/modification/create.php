<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\product\ModificationCreateForm */
/* @var $product \store\entities\shop\product\Product */

$this->title = 'Добавление модификации';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/shop/product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['/shop/product/view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modification-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
    ]) ?>
    <div class="box">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'image')->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                ]
            ]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>

</div>
