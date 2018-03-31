<?php

/* @var $product \store\entities\shop\product\Product */
/* @var $this \yii\web\View */
/* @var $model \store\forms\manage\shop\product\ProductEditForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавление атрибутов товара: ' . $product->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = 'Добавление';
?>

<div class="product-attributes">
    <?php $form = ActiveForm::begin() ?>
    <div style="display: none;">
            <?= $form->field($model, 'makerId')->dropDownList($model->makerList(), ['prompt' => '']) ?>
            <?= $form->field($model, 'brandId')->dropDownList($model->brandList(), ['prompt' => '']) ?>
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="box">
        <div class="box-header with-border">Атрибуты</div>
        <div class="box-body">
            <div class="row">
                <?php foreach ($model->values as $i => $value): ?>
                    <div class="col-sm-6">
                        <?= $form->field($value, '[' . $i . ']text')->textInput(['maxlength' => true]) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
