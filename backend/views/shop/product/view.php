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
use yii\helpers\Url;
use store\entities\shop\product\Review;

/* @var $this yii\web\View */
/* @var $product store\entities\shop\product\Product */
/* @var $photosForm \store\forms\manage\shop\product\PhotosForm */
/* @var $modificationsProvider \yii\data\ActiveDataProvider */
/* @var $reviewProvider \yii\data\ActiveDataProvider */

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
        <?php if (!$product->isSale()): ?>
        <?= Html::a('Добавить к распродаже', ['sale', 'id' => $product->id], ['class' => 'btn btn-warning', 'data-method' => 'post']) ?>
        <?php else: ?>
        <?= Html::a('Удалить из распродажи', ['un-sale', 'id' => $product->id], ['class' => 'btn btn-info', 'data-method' => 'post']) ?>
        <?php endif; ?>
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
                        'value' => $product->mainPhoto ? Html::img($product->mainPhoto->getThumbFileUrl('file', 'admin'))  : null,
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
                        'value' => implode(', ',  ArrayHelper::getColumn($product->tags, 'name')) ,
                    ],
                    'rating',
                    'slug',
                    'created_at:datetime',
                    'updated_at:datetime',
                    'body:html',
                ],
            ]) ?>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header with-border">Складские свойства</div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $product,
                        'attributes' => [
                            [
                                'attribute' => 'weight',
                                'value' => WeightHelper::format($product->weight),
                                'format' => 'html'
                            ],
                            'quantity',
                        ],
                    ]) ?>
                    <div>
                        <?= Html::a('Изменить количество', ['quantity', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header with-border">Настройки цены</div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $product,
                        'attributes' => [
                            [
                                'attribute' => 'price_old',
                                'value' => PriceHelper::format($product->price_old),
                                'format' => 'html'
                            ],
                            [
                                'attribute' => 'price_new',
                                'value' => PriceHelper::format($product->price_new),
                                'format' => 'html',
                            ],
                        ],
                    ]) ?>
                </div>
                <div>
                    <?= Html::a('Изменить цену', ['price', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
    <br>


    <div class="box">
        <div class="box-header with-border">Атрибуты товара</div>
        <div class="box-body">
            <?php if (count($product->productValues) > 0 ): ?>
                <?= DetailView::widget([
                    'model' => $product,
                    'attributes' => array_map(function (ProductValue $value){
                        return [
                            'label' => $value->characteristic->name,
                            'value' => $value->value,
                        ];
                    }, $product->productValues)
                ]) ?>
            <?php else: ?>
                <p>
                    Атрибуты к этому товару еще не добавлены. Перейдите в редактирование и добавьте атрибуты.
                </p>
            <?php  endif; ?>
        </div>
    </div>


    <div class="box" id="modifications">
        <div class="box-header with-border">Модификации товара</div>
        <div class="box-body">
            <p>
                <?= Html::a('Добавить модификацию', ['shop/modification/create', 'product_id' => $product->id], ['class' => 'btn btn-primary']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $modificationsProvider,
                'columns' => [
                    [
                        'value' => function(Modification $modification)
                        {
                            return $modification->image ? Html::a(Html::img($modification->getThumbFileUrl('image', 'modification'), ['class' => 'img-responsive']), $modification->getThumbFileUrl('image', 'full'), ['class' => 'fancybox']) : null;
                        },
                        'format' => 'html'
                    ],
                    'name',
                    'code',
                    [
                        'attribute' => 'price',
                        'value' => function(Modification $modification)
                        {
                            return PriceHelper::format($modification->price);
                        },
                        'format' => 'html',
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

    <div class="box" id="reviews">
        <div class="box-header with-border">Отзывы</div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $reviewProvider,
                'columns' => [
                    [
                        'attribute' => 'user_id',
                        'value' => function(Review $review)
                        {
                            return $review->user->username;
                        }
                    ],
                    'vote',
                    [
                        'attribute' => 'active',
                        'value' => function(Review $review)
                        {
                            return $review->active ? '<span class="label label-success">Опубликован</span>' : '<span class="label label-danger">Отключен</span>';
                        },
                        'format' => 'raw',
                    ],
                    [
                        'value' => function(Review $review) use($product)
                        {
                            if ($review->isDraft()){
                                return Html::a('Опубликовать', ['/shop/review/activate', 'id' => $product->id, 'reviewId' => $review->id], ['class' => 'btn btn-success', 'data-method' => 'post']);
                            }else{
                                return Html::a('Отключить', ['/shop/review/draft', 'id' => $product->id, 'reviewId' => $review->id], ['class' => 'btn btn-danger', 'data-method' => 'post']);
                            }
                        },
                        'format' => 'raw',
                    ],
                    'created_at:datetime',
                    [
                        'class' => ActionColumn::class,
                        'controller' => 'shop/review',
                        'template' => ' {update} {delete}',
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

    <div class="box" id="photos">
        <div class="box-header with-border">Фотографии</div>
        <div class="box-body">

            <div class="row">
                <?php foreach ($product->photos as $photo): ?>
                    <div class="col-sm-2" style="text-align: center">
                        <div class="btn-group">
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $product->id, 'photoId' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['remove-photo', 'id' => $product->id, 'photoId' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                                'data-confirm' => 'Удалить фото?',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $product->id, 'photoId' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                        </div>
                        <div>
                            <a href="<?= Url::to($photo->getThumbFileUrl('file', 'full')) ?>" class="fancybox">
                                <?= Html::img($photo->getThumbFileUrl('file', 'full'), ['class' => 'img-responsive'])?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <br><br>

            <?php $form = ActiveForm::begin([
                'options' => ['enctype'=>'multipart/form-data'],
            ]); ?>

            <?= $form->field($photosForm, 'files[]')->label(false)->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                ]
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Закачать', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>


        </div>
