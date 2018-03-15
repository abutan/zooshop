<?php

use yii\helpers\Html;
use yii\grid\GridView;
use store\helpers\CallHelper;
use store\entities\site\Call;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\CallSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы звонка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="call-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                        'value' => function(Call $call)
                        {
                            return Html::a(Html::encode($call->name), ['view', 'id' => $call->id]);
                        },
                        'format' => 'html',
                    ],
                    'phone',
                    [
                        'attribute' => 'status',
                        'filter' => CallHelper::statusList(),
                        'value' => function(Call $call)
                        {
                            return CallHelper::statusLabel($call->status);
                        },
                        'format' => 'html',
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>
