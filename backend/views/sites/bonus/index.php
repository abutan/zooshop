<?php

use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\site\Bonus;
use store\helpers\BonusHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\BonusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Бонусы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bonus-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить бонус', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'value' => function(Bonus $bonus)
                        {
                            return Html::a(Html::encode($bonus->name), ['view', 'id' => $bonus->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => BonusHelper::statusList(),
                        'value' => function(Bonus $bonus)
                        {
                            return BonusHelper::StatusLabel($bonus->status);
                        },
                        'format' => 'raw',
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
