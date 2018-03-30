<?php

use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\shop\order\PaymentMethod;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Методы оплаты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-method-index">

    <p>
        <?= Html::a('Добавить метод оплаты', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                        'attribute' => 'name',
                        'value' => function(PaymentMethod $method)
                        {
                            return Html::a(Html::encode($method->name), ['view', 'id' => $method->id]);
                        },
                        'format' => 'raw',
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
