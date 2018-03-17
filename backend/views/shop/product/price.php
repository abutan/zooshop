<?php
/* @var $this \yii\web\View */
/* @var $product \store\entities\shop\product\Product */
/* @var $model \store\forms\manage\shop\product\PriceForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Цена товара ' . $product->name;

$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = 'Цена';
?>

<div class="product-price">
    <?php $form = ActiveForm::begin() ?>
    <div class="box">
        <div class="box-body">
            <?= $form->field($model, 'old')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'new')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
