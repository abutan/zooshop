<?php

use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\site\Slider;
use store\helpers\SliderHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Слайдеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить слайдер', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'value' => function(Slider $slider)
                        {
                            return Html::a(Html::encode($slider->name), ['view', 'id' => $slider->id]);
                        },
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => SliderHelper::statusList(),
                        'value' => function(Slider $slider)
                        {
                            return SliderHelper::statusLabel($slider->status);
                        },
                        'format' => 'html',
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
