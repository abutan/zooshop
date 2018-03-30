<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\grid\GridView;
use store\entities\shop\product\Product;
use store\helpers\PriceHelper;
use yii\grid\ActionColumn;

$this->title = 'Избранное (лист желаний)';

$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cabinet-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'value' => function(Product $product)
                {
                    return $product->main_photo_id ? Html::img($product->mainPhoto->getThumbFileUrl('file', 'full'), ['alt' => $product->name, 'class' => 'img-responsive', 'style' => 'max-height: 70px; margin: auto;']) : null;
                },
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 100px'],
            ],
            'id',
            [
                'attribute' => 'name',
                'value' => function(Product $product)
                {
                    return Html::a(Html::encode($product->name) , ['/shop/catalog/product', 'id' => $product->id]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'price_new',
                'value' => function(Product $product)
                {
                    return PriceHelper::format($product->price_new);
                },
                'format' => 'raw',
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{delete}',
            ],
        ],
    ]) ?>
</div>
