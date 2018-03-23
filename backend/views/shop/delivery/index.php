<?php

use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\shop\DeliveryMethod;
use store\helpers\PriceHelper;
use store\helpers\WeightHelper;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\DeliverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Методы доставки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-method-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить метод доставки', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                        'attribute' => 'name',
                        'value' => function(DeliveryMethod $method)
                        {
                            return Html::a(Html::encode($method->name), ['view', 'id' => $method->id]);
                        },
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'cost',
                        'value' => function(DeliveryMethod $method)
                        {
                            return PriceHelper::format($method->cost);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'min_price',
                        'value' => function(DeliveryMethod $method)
                        {
                            return PriceHelper::format($method->min_price);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'max_price',
                        'value' => function(DeliveryMethod $method)
                        {
                            return PriceHelper::format($method->max_price);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'min_weight',
                        'value' => function(DeliveryMethod $method)
                        {
                            return WeightHelper::format($method->min_weight);
                        }
                    ],
                    [
                        'attribute' => 'max_weight',
                        'value' => function(DeliveryMethod $method)
                        {
                            return WeightHelper::format($method->max_weight);
                        }
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
