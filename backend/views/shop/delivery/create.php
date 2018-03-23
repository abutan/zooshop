<?php


/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\DeliveryForm */

$this->title = 'Добавление метода доставки';
$this->params['breadcrumbs'][] = ['label' => 'Методы доставкик', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-method-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
