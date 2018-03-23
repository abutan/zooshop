<?php

use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\shop\Discount;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\DiscountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Скидки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить скидку', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'value' => function(Discount $discount)
                        {
                            return Html::a(Html::encode($discount->name), ['view', 'id' => $discount->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'active',
                        'filter' => $searchModel->activeList(),
                        'value' => function(Discount $discount)
                        {
                            return $discount->active ? '<span class="label label-success">Активно</span>' : '<span class="label label-danger">Отключено</span>';
                        },
                        'format' => 'raw',
                    ],
                    'percent',
                    'from_date',
                    'to_date',


                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
