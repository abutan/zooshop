<?php
/* @var $product  */
/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use store\helpers\PriceHelper;
use yii\helpers\StringHelper;

$url = Url::to(['product', 'id' => $product->id]);
?>

<div class="product-layout col-sm-4">
    <div class="product-thumb">

        <?php if ($product->mainPhoto): ?>
            <div class="product-image">
                <a href="<?= Html::encode($url) ?>">
                    <?= Html::img($product->mainPhoto->getThumbFileUrl('file', 'list'), ['alt' => $product->name, 'class' => 'img-responsive']) ?>
                </a>
            </div>
        <?php endif; ?>
        <div class="product-caption">

            <a href="<?= Html::encode($url) ?>">
                <h4 data-toggle="tooltip" title="<?= $product->name ?>">
                    <?= Html::encode(StringHelper::truncateWords($product->name, 2)) ?>
                </h4>
            </a>
            <p class="price">
                <?php if ($product->price_old): ?>

                    <span class="price-old">
                        <del style="color: #ff0000;">
                            <?= PriceHelper::format($product->price_old) ?>
                        </del>
                    </span>

                <?php endif; ?>
                <span class="price-new">
                    <?= PriceHelper::format($product->price_new) ?>
                </span>
            </p>
        </div>
        <div class="button-group">
            <button type="button" class="btn btn-add-to-cart" href="<?= Url::to(['/shop/cart/add', 'id' => $product->id])  ?>" data-method="post">
                <i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">Добавить в корзину</span>
            </button>
            <?php if (Yii::$app->user->isGuest): ?>
                <button type="button" class="attButton" href="<?= Html::encode(Url::to(['/shop/catalog/attention']))  ?>" data-toggle="tooltip" title="Добавить в избранное (лист желаний)">
                    <i class="fa fa-heart text-danger"></i>
                </button>
            <?php else: ?>
                <button type="button" href="<?= Url::to(['/cabinet/whishlist/add', 'id' => $product->id]) ?>" data-toggle="tooltip" title="Добавить в избранное (лист желаний)" data-method="post">
                    <i class="fa fa-heart text-danger"></i>
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>