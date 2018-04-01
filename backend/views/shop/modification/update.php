<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\product\ModificationEditForm */
/* @var $product \store\entities\shop\product\Product */
/* @var $modification \store\entities\shop\product\Modification */

$this->title = 'Редактирование модификации: ' . $modification->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/shop/product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['/shop/product/view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = $modification->name;
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="modification-update">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
    ]) ?>
    <div class="box">
        <div class="box-header with-border">Модификация</div>
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


    <div class="box">
        <div class="box-header with-border">Атрибуты</div>
        <div class="box-body">
            <?php foreach ($model->modificationValues as $i => $value): ?>
                <?= $form->field($value, '[' . $i . ']value')->textInput() ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>

</div>
