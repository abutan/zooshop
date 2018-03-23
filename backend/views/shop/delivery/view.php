<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use store\helpers\PriceHelper;
use store\helpers\WeightHelper;

/* @var $this yii\web\View */
/* @var $model \store\forms\manage\shop\DeliveryForm */
/* @var $method \store\entities\shop\DeliveryMethod */

$this->title = $method->name;
$this->params['breadcrumbs'][] = ['label' => 'Delivery Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-method-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $method->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $method->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $method,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'cost',
                'value' => PriceHelper::format($method->cost),
                'format' => 'html',
            ],
            [
                'attribute' => 'min_price',
                'value' => PriceHelper::format($method->min_price),
                'format' => 'html',
            ],
            [
                'attribute' => 'max_price',
                'value' => PriceHelper::format($method->max_price),
                'format' => 'html',
            ],
            [
                'attribute' => 'min_weight',
                'value' => WeightHelper::format($method->min_weight),
            ],
            [
                'attribute' => 'max_weight',
                'value' => WeightHelper::format($method->max_weight),
            ],
            'sort',
        ],
    ]) ?>

</div>
