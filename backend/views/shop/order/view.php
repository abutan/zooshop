<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use store\helpers\PriceHelper;
use store\helpers\OrderHelper;

/* @var $this yii\web\View */
/* @var $order \store\entities\shop\order\Order */

$this->title = $order->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">
    <p>
        <?php if (!$order->isCancelled()) ?>
        <?php if ($order->isNew()): ?>
            <?= Html::a('Отметить как укомплектованный', ['complete', 'id' => $order->id], ['class' => 'btn btn-primary', 'data-method' => 'post']) ?>
        <?php elseif ($order->isCompleted()): ?>
            <?= Html::a('Отметить как отправленный', ['sent', 'id' => $order->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php else: ?>
        <?= Html::tag('span', 'Заказ аннулирован', ['class' => 'btn btn-default']) ?>
        <?php endif; ?>
        <?= Html::a('Редактировать', ['update', 'id' => $order->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $order->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php if (!$order->isCancelled()): ?>
        <?= Html::a('Аннулировать заказ', ['cancel', 'id' => $order->id], ['class' => 'btn btn-danger', 'data-method' => 'post', 'data-toggle' => 'tooltip', 'title' => 'Админ! Если ты аннулировать заказ, не забудь перейти в редактирование и написать причину аннуляции']) ?>
        <?php endif; ?>
        <?php if ($order->payment_method == 1 && !$order->isPaid()):?>
        <?= Html::a('Отметить заказ как оплаченный', ['pay', 'id' => $order->id], ['class' => 'btn btn-warning', 'data-method' => 'post']) ?>
        <?php elseif ($order->payment_method == 1 && $order->isPaid()): ?>
        <?= Html::tag('span', 'Заказ оплачен', ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
        <?php if ($order->payment_method == 2 && !$order->isPaid()): ?>
        <?= Html::tag('span', 'Заказ еще не оплачен', ['class' => 'btn btn-default']) ?>
        <?php elseif ($order->payment_method == 2 && $order->isPaid()): ?>
        <?= Html::tag('span', 'Заказ оплачен', ['class' => 'btn btn-success']) ?>
        <?php elseif ($order->payment_method == 2 && $order->isFail()): ?>
        <?= Html::tag('span', 'Оплата заказа не прошла', ['class' => 'btn btn-warning']) ?>
        <?php endif; ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Данные пользователя и заказа</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $order,
                'attributes' => [
                    'id',
                    'user_id',
                    'customer_phone',
                    'customer_name',
                    [
                        'attribute' => 'cost',
                        'value' => PriceHelper::format($order->cost),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'status',
                        'value' => OrderHelper::statusLabel($order->status),
                        'format' => 'raw',
                    ],
                    'created_at:datetime',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">Данные для доставки</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $order,
                'attributes' => [
                    'delivery_method_name',
                    [
                        'attribute' => 'delivery_cost',
                        'value' => PriceHelper::format($order->delivery_cost),
                        'format' => 'raw',
                    ],
                    'delivery_address:ntext',
                    'delivery_index',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">Способ оплаты</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $order,
                'attributes' => [
                    [
                        'attribute' => 'payment_method',
                        'value' => $order->payment->name,
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">Комметарий к заказу</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $order,
                'attributes' => [
                    'note:ntext',
                ],
            ]) ?>
        </div>
    </div>
    <?php if ($order->isCancelled()): ?>
        <div class="box">
            <div class="box-header with-border">Причины аннуляции заказа</div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $order,
                    'attributes' => [
                        'cancel_reason:ntext',
                    ],
                ]) ?>
            </div>
        </div>
    <?php endif; ?>


</div>
