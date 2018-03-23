<?php

/* @var $this yii\web\View */
/* @var $method \store\entities\shop\DeliveryMethod */
/* @var $model \store\forms\manage\shop\DeliveryForm */

$this->title = 'Редакторование метода доставки: ' . $method->name;
$this->params['breadcrumbs'][] = ['label' => 'Методы доставки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $method->name, 'url' => ['views', 'id' => $method->id]];
$this->params['breadcrumbs'][] = 'Редактирвание';
?>
<div class="delivery-method-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
