<?php

/* @var $this \yii\web\View */
/* @var $order null|\store\entities\shop\order\Order */

use store\helpers\PriceHelper;
use store\helpers\OrderHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Заказ '.$order->id;
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/cabinet/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-view">
    <div class="panel panel-default">
        <div class="panel-heading"><h1><?= Html::encode($this->title) ?></h1></div>
        <div class="panel-body">
            <?=
            DetailView::widget([
                'model' => $order,
                'attributes' => [
                    'id',
                    'created_at:datetime',
                    [
                        'attribute' => 'status',
                        'value' => OrderHelper::statusLabel($order->status),
                        'format' => 'html',
                    ],
                    'delivery_method_name',
                    'delivery_index',
                    'delivery_address',
                    [
                        'attribute' => 'cost',
                        'value' => PriceHelper::format($order->cost),
                        'format' => 'raw',
                    ],
                    'payment.name',
                    'note:ntext',
                ],
            ])
            ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-left">Название товара</th>
                        <th class="text-left">Модель</th>
                        <th class="text-left">Количество</th>
                        <th class="text-right">Цена за ед-цу</th>
                        <th class="text-right">Всего</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($order->items as $item): ?>
                        <tr>
                            <td class="text-left">
                                <?= Html::encode($item->product_name) ?>
                                <?= Html::encode($item->product_code) ?>
                            </td>
                            <td class="text-left">
                                <?= Html::encode($item->modification_name) ?>
                                <?= Html::encode($item->modification_code) ?>
                            </td>
                            <td class="text-left">
                                <?= $item->quantity ?>
                            </td>
                            <td class="text-right"><?= PriceHelper::format($item->price) ?> </td>
                            <td class="text-right"><?= PriceHelper::format($item->getCost()) ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($order->canBePaid()): ?>
                <?php if ($order->payment_method == 1): ?>
                    <p>
                        Спасибо! Свяжитесь пожалуйста с менеджером по телефону +7(999)1234567 и уточните подробности получения этого заказа.
                    </p>
                <?php elseif ($order->payment_method == 2): ?>
                    <?= Html::a('Оплатить заказ', ['/payment/robocassa/invoice', 'id' => $order->id], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>