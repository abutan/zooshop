<?php


/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\DiscountForm */

$this->title = 'Добавление скидки';
$this->params['breadcrumbs'][] = ['label' => 'Скидки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
