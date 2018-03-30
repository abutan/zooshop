<?php


/* @var $this yii\web\View */
/* @var $model \store\forms\manage\order\PaymentForm */

$this->title = 'Добавление метода оплаты';
$this->params['breadcrumbs'][] = ['label' => 'Методы оплаты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-method-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
