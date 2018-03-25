<?php
/* @var $product null|\store\entities\shop\product\Product */
/* @var $this \yii\web\View */
/* @var $reviewForm \store\forms\shop\ReviewForm */
/* @var $addToCart \store\forms\shop\AddToCartForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use yii\widgets\Breadcrumbs;
use store\helpers\PriceHelper;


$this->title = $product->getTitle();

$this->registerMetaTag(['name' => 'description', 'content' => $product->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $product->keywords]);

foreach ($product->category->parents as $parent){
    if (!$parent->isRoot()){
        $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'id' => $parent->id]];
    }
}
$this->params['breadcrumbs'][] = ['label' => $product->category->name, 'url' => ['category', 'id' => $product->category->id]];
$this->params['breadcrumbs'][] = $product->name;

$this->params['active_category'] = $product->category;
?>

<div class="row single-product-page" xmlns:fb="http://www.w3.org/1999/xhtml">

    <h1><?= Html::encode($product->name) ?></h1>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-5 product-main-photo">
                <?php if ($product->main_photo_id): ?>
                    <a href="<?= $product->mainPhoto->getThumbFileUrl('file', 'full') ?>" class="fancybox" rel="gallery<?= $product->id ?>" title="<?= $product->name ?>">
                        <?= Html::img($product->mainPhoto->getThumbFileUrl('file', 'full'), ['alt' => $product->name, 'class' => 'img-responsive']) ?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="col-sm-7">
                <div class="row">
                    <?php foreach ($product->photos as $photo): ?>
                        <?php if ($photo->id !== $product->mainPhoto->id): ?>
                        <div class="col-sm-4 product-other-photos">
                            <a href="<?= $photo->getThumbFileUrl('file', 'full') ?>" class="fancybox"  rel="gallery<?= $product->id ?>" title="<?= $product->name ?>">
                                <?= Html::img($photo->getThumbFileUrl('file', 'full'), ['alt' => $product->name, 'class' => 'img-responsive']) ?>
                            </a>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>

        <?php
        $description = Yii::$app->formatter->asHtml($product->description, [
            'Attr.AllowedRel' => array('nofollow'),
            'HTML.SafeObject' => true,
            'Output.FlashCompat' => true,
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]);
        ?>

        <?=
        Tabs::widget([
            'items' => [
                [
                    'label' => 'Описание',
                    'content' => $description,
                    'active' => TRUE,
                ],
                [
                    'label' => 'Отзывы',
                    'content' => $this->render('_review', [
                        'reviewForm' => $reviewForm
                    ])
                ],
            ],
        ])
        ?>
    </div>

    <div class="col-sm-5">
        <p class="btn-group">
            <?php if (Yii::$app->user->isGuest): ?>
                <button type="button" data-toggle="tooltip" class="btn btn-default attButton" title="Добавить в избранное" href="<?= Html::encode(Url::to(['/shop/catalog/attention'])) ?>"><i class="fa fa-heart"></i></button>
            <?php else: ?>
                <button type="button" data-toggle="tooltip" class="btn btn-default" title="Добавить в избранное" href="<?= Url::to(['/cabinet/wishlist/add', 'id' => $product->id]) ?>" data-method="post"><i class="fa fa-heart"></i></button>
            <?php endif; ?>

            <button type="button" data-toggle="tooltip" class="btn btn-default" title="Сравнить этот товар" onclick="compare.add('47');"><i class="fa fa-exchange"></i></button>
        </p>

        <ul class="list-unstyled common-properties">
            <li>
                Производитель: <?= Html::a(Html::encode($product->maker->name), ['maker', 'slug' => $product->maker->slug], ['class' => 'common-description-link']) ?>
            </li>
            <li>
                Бренд: <?= Html::a(Html::encode($product->brand->name), ['brand', 'slug' => $product->brand->slug], ['class' => 'common-description-link']) ?>
            </li>
            <li>
                Теги:
                <?php foreach ($product->tags as $tag): ?>
                    <?= Html::a(Html::encode($tag->name), ['tag', 'slug' => $tag->slug], ['class' => 'common-description-link']) ?>
                <?php endforeach; ?>
            </li>
            <li>
                Артикул: <?= $product->code ?>
            </li>
        </ul>
        <ul class="list-unstyled common-price">
            <li>
                <?= PriceHelper::format($product->price_new) ?>
            </li>
        </ul>
        <div class="product-adding">
            <?php $form = ActiveForm::begin([
                'action' => ['/shop/cart/add', 'id' => $product->id]
            ]) ?>

            <?= $form->field($addToCart, 'quantity')->textInput(['type' => 'number', 'min' => 1, 'step' => 1]) ?>

            <div class="form-group">
                <?= Html::submitButton('Добавить в корзину', ['class' => 'btn btn-success btn-lg btn-block']) ?>
            </div>

            <?php ActiveForm::end() ?>
        </div>

        <div class="rating">
            <p>
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                <br>
                <a href="" onclick="$('a[href=\'#w0-tab1\']').trigger('click'); return false;">0 отзывов </a> / <a href="" onclick="$('a[href=\'#w0-tab1\']').trigger('click'); return false;">Написать отзыв</a>
            </p>
            <hr>
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style" data-url="/index.php?route=product/product&amp;product_id=47">
                <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> &nbsp;
                <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> &nbsp;
                <a class="addthis_counter addthis_pill_style"></a>
            </div>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
            <!-- AddThis Button END -->
        </div>
    </div>

</div>