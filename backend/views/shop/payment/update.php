<?php

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\order\PaymentForm */
/* @var $method \store\entities\shop\order\PaymentMethod */

$this->title = 'Редактирование метода оплаты: ' . $method->name;
$this->params['breadcrumbs'][] = ['label' => 'Методы оплаты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $method->name, 'url' => ['view', 'id' => $method->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="payment-method-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
