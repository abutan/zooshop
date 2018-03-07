<?php

use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\shop\Maker;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\MakerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Производители';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maker-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить производителя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'name',
                'value' => function(Maker $maker)
                {
                    return Html::a(Html::encode($maker->name), ['view', 'id' => $maker->id]);
                },
                'format' => 'html',
            ],
            'slug',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
