<?php

use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\shop\order\Order;
use store\helpers\OrderHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'value' => function(Order $order)
                {
                    return Html::a(Html::encode($order->id), ['view', 'id' => $order->id]);
                },
                'format' => 'raw',
            ],
            'user.username',
            [
                'attribute' => 'status',
                'filter' => OrderHelper::statusList(),
                'value' => function(Order $order)
                {
                    return OrderHelper::statusLabel($order->status);
                },
                'format' => 'raw',
            ],
            'customer_phone',
            'customer_name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
</div>
