<?php
/* @var $this \yii\web\View */
/* @var $product \store\entities\shop\product\Product */
/* @var $model \store\forms\manage\shop\product\QuantityForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Количество товара ' . $product->name;

$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = 'Количество';
?>

<div class="product-quantity">
    <?php $form = ActiveForm::begin() ?>
    <div class="box">
        <div class="box-body">
            <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
