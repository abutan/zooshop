<?php

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\order\OrderEditForm */
/* @var $order \store\entities\shop\order\Order */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->title = 'Редактирование заказа: ' . $order->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $order->id, 'url' => ['view', 'id' => $order->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-update">

    <?php $form = ActiveForm::begin() ?>

    <div class="box">
        <div class="box-header with-border">Данные покупателя</div>
        <div class="box-body">
            <?= $form->field($model, 'customerName')->textInput(['maxlength' => 'true']) ?>
            <?= $form->field($model, 'customerPhone')->widget(MaskedInput::class, [
                'mask' => '+7 (999) 999 - 99 - 99',
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'Контактный телефон',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">Данные для доставки</div>
        <div class="box-body">
            <?= $form->field($model->delivery, 'method')->dropDownList($model->delivery->deliveryMethodList(), ['prompt' => ' --- Выбрать --- ']) ?>
            <?= $form->field($model->delivery, 'index')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->delivery, 'address')->textarea(['rows' => 3]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">Способ оплаты</div>
        <div class="box-body">
            <?= $form->field($model, 'payment')->dropDownList($model->paymentList(), ['prompt' => ' --- Выберите --- ']) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">Комметарий к заказу</div>
        <div class="box-body">
            <?= $form->field($model, 'note')->textarea(['rows' => 3]) ?>
        </div>
    </div>

    <?php if ($order->isCancelled()): ?>
        <div class="box">
            <div class="box-header with-border">Причины аннуляции заказа</div>
            <div class="box-body">
                <?= $form->field($model, 'cancelReason')->label(false)->textarea(['rows' => 3]) ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>

</div>
