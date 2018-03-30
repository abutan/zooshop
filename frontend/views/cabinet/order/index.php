<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\shop\order\Order;
use store\helpers\OrderHelper;

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-index">
    <div class="panel panel-default">
        <div class="panel-heading"> <h1><?= Html::encode($this->title) ?></h1> </div>
        <div class="panel-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'id',
                        'value' => function(Order $order)
                        {
                            return Html::a(Html::encode($order->id), ['view', 'id' => $order->id]);
                        },
                        'format' => 'html',
                    ],
                    'created_at:datetime',
                    [
                        'attribute' => 'current_status',
                        'value' => function(Order $order)
                        {
                            return OrderHelper::statusLabel($order->status);
                        },
                        'format' => 'html',
                    ],
                ],
            ])
            ?>
        </div>
    </div>

</div>