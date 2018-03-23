<?php

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\DiscountForm */
/* @var $discount \store\entities\shop\Discount */

$this->title = 'Редактирование скидки: ' . $discount->name;
$this->params['breadcrumbs'][] = ['label' => 'Скидки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $discount->name, 'url' => ['view', 'id' => $discount->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="discount-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
