<?php

use yii\helpers\Html;
use yii\grid\GridView;
use store\entities\shop\product\Product;
use store\helpers\ProductHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'attribute' => 'main_photo_id',
                        'value' => function(Product $product)
                        {
                            return $product->mainPhoto ? Html::img($product->mainPhoto->getThumbFileUrl('file', 'admin')) : null;
                        },
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'name',
                        'value' => function(Product $product)
                        {
                            return Html::a(Html::encode($product->name), ['view', 'id' => $product->id]);
                        },
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'category_id',
                        'filter' => $searchModel->categoriesList(),
                        'value' => 'category.name',
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => ProductHelper::statusList(),
                        'value' => function(Product $product)
                        {
                            return ProductHelper::statusLabel($product->status);
                        },
                        'format' => 'html',
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
