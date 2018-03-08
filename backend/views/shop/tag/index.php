<?php

use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\shop\Tag;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Теги (метки)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавление тега (метки)', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'value' => function(Tag $tag)
                        {
                            return Html::a(Html::encode($tag->name), ['view', 'id' => $tag->id]);
                        },
                        'format' => 'html',
                    ],
                    'slug',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
