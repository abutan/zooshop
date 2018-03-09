<?php

use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\shop\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить категорию', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'value' => function(Category $model){
                            $indent = ($model->depth > 1 ? str_repeat(' -- ', $model->depth - 1). '  ' : '');
                            return $indent.Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'value' => function(Category $model){
                            return
                                Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $model->id]).Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $model->id]);
                        },
                        'format' => 'html',
                        'contentOptions' => ['style' => 'text-align: center'],
                    ],
                    'slug',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
