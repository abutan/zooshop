<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use store\helpers\ProductHelper;
use store\helpers\PriceHelper;
use store\helpers\WeightHelper;
use store\entities\shop\product\ProductValue;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use store\entities\shop\product\Modification;

/* @var $this yii\web\View */
/* @var $product store\entities\shop\product\Product */
/* @var $photosForm \store\forms\manage\shop\product\PhotosForm */
/* @var $modificationsProvider \yii\data\ActiveDataProvider */

$this->title = $product->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <p>
        <?php if ($product->isDraft()): ?>
        <?= Html::a('Опубликовать', ['activate', 'id' => $product->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php else: ?>
        <?= Html::a('Отключить', ['draft', 'id' => $product->id], ['class' => 'btn btn-danger', 'data-method' => 'post']) ?>
        <?php endif; ?>
        <?= Html::a('Редактировать', ['update', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $product->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Общие свойства товара</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $product,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'main_photo_id',
                        'value' => $product->mainPhoto->getThumbFileUrl('file', 'admin'),
                        'format' => 'html',
                    ],
                    'code',
                    'name',
                    [
                        'attribute' => 'status',
                        'value' => ProductHelper::statusLabel($product->status),
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'category_id',
                        'value' => ArrayHelper::getValue($product, 'category.name')
                    ],
                    [
                        'label' => 'Дополнительные категории',
                        'value' => implode(', ', ArrayHelper::getColumn($product->categories, 'name')),
                    ],
                    [
                        'attribute' => 'brand_id',
                        'value' => ArrayHelper::getValue($product, 'brand.name'),
                    ],
                    [
                        'attribute' => 'maker_id',
                        'value' => ArrayHelper::getValue($product, 'maker.name'),
                    ],
                    [
                        'label' => 'Теги (метки)',
                        'value' => ArrayHelper::getColumn($product->tags, 'name'),
                    ],
                    'body:ntext',
                    'price_old',
                    'price_new',

                    'rating',
                    'slug',
                    'created_at',
                    'updated_at',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row col-sm-6">
        <div class="box">
            <div class="box-header with-border">Складские свойства</div>
            <div class="box-body">
                <?= DetailView::widget([
                        'model' => $product,
                    'attributes' => [
                        [
                            'attribute' => 'weight',
                            'value' => WeightHelper::format($product->weight),
                        ],
                        'quantity',
                    ],
                ]) ?>
                <div class="text-center">
                    <?= Html::a('Изменить количество', ['quantity', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row col-sm-6">
        <div class="box">
            <div class="box-header with-border">Настройки цены</div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $product,
                    'attributes' => [
                        [
                            'attribute' => 'price_old',
                            'value' => PriceHelper::format($product->price_old),
                        ],
                        [
                            'attribute' => 'price_new',
                            'value' => PriceHelper::format($product->price_new),
                        ],
                    ],
                ]) ?>
            </div>
            <div class="text-center">
                <?= Html::a('Изменить цену', ['price', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php if (count($product->values) > 0 ): ?>
        <?= DetailView::widget([
            'model' => $product,
            'attributes' => array_map(function (ProductValue $value){
                return [
                    'label' => $value->characteristic->name,
                    'value' => $value->value,
                ];
            }, $product->values)
        ]) ?>
    <?php else: ?>
    <?= Html::a('Установить атрибуты товару', ['value', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
    <?php  endif; ?>

    <div class="box" id="modifications">
        <div class="box-header with-border">Модификации товара</div>
        <div class="box-body">
            <p></p>
            <?= GridView::widget([
                'dataProvider' => $modificationsProvider,
                'columns' => [
                    'name',
                    'code',
                    [
                        'attribute' => 'price',
                        'value' => function(Modification $modification)
                        {
                            return PriceHelper::format($modification->price);
                        }
                    ],
                    'quantity',
                    [
                        'class' => ActionColumn::class,
                        'controller' => 'shop/modification',
                        'template' => '{update} {delete}',
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">SEO</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $product,
                'attributes' => [
                    'title',
                    'description',
                    'keywords',
                ],
            ]) ?>
        </div>
    </div>


    .box>.box-header.with-border{Общие свойства товара}+.box-body
    <?= DetailView::widget([
        'model' => $product,
        'attributes' => [
            'id',
            'code',
            'name',
            'main_photo_id',
            'category_id',
            'brand_id',
            'maker_id',
            'body:ntext',
            'price_old',
            'price_new',
            'weight',
            'quantity',
            'rating',
            'slug',
            'status',
            'title',
            'description',
            'keywords',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
