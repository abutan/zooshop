<?php

/* @var $product \store\entities\shop\product\Product */
/* @var $this \yii\web\View */
/* @var $model \store\forms\manage\shop\product\ProductRelatesForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сопуствующие товары для '. $product->name;

$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = 'Сопутствующие товары';
?>

<div class="product-relates">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'products')->checkboxList($model->relatedList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
