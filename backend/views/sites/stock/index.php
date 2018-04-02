<?php

use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\site\Stock;
use store\helpers\StockHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\StockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Акции (скидки)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить акцию (скидку)', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'value' => function(Stock $stock)
                        {
                            return Html::a(Html::encode($stock->name), ['view', 'id' => $stock->id]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => StockHelper::statusList(),
                        'value' => function(Stock $stock)
                        {
                            return StockHelper::StatusLabel($stock->status);
                        },
                        'format' => 'raw',
                    ],
                    'slug',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
