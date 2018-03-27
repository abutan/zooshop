<?php

/* @var $this \yii\web\View */
/* @var $cart \store\cart\Cart */

use yii\helpers\Html;
use yii\helpers\Url;
use store\helpers\PriceHelper;
use store\helpers\WeightHelper;
use yii\widgets\Breadcrumbs;

$this->title = 'Корзина товаров';

$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['/shop/catalog/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cart-index container-fluid">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td class="text-center" style="width: 100px"></td>
                <td class="text-left">Название</td>
                <td class="text-left">Модель</td>
                <td class="text-left">Количество</td>
                <td class="text-right">Цена за ед-цу</td>
                <td class="text-right">Всего</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cart->getItems() as $item): ?>
                <?php
                $product = $item->getProduct();
                $modification = $item->getModification();
                $url = Url::to(['/shop/catalog/product', 'id' => $product->id]);
                ?>
                <tr>
                    <td class="text-center cart-image">
                        <a href="<?= $url ?>">
                            <?php if ($product->main_photo_id): ?>
                                <img src="<?= $product->mainPhoto->getThumbFileUrl('file', 'full') ?>" alt="<?= $product->name ?>" class="img-responsive" />
                            <?php endif; ?>
                        </a>
                    </td>
                    <td class="text-left">
                        <a href="<?= $url ?>"><?= Html::encode($product->name) ?></a>
                    </td>
                    <td class="text-left">
                        <?php if ($modification): ?>
                            <?= Html::encode($modification->name) ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-left">
                        <?= Html::beginForm(['quantity', 'id' => $item->getId()]); ?>
                        <div class="input-group btn-block" style="max-width: 200px;">
                            <label for="quantity" class="sr-only">Количество</label>
                            <input id="quantity" type="text" name="quantity" value="<?= $item->getQuantity() ?>" size="1" class="form-control" />
                            <span class="input-group-btn">
                                    <button type="submit" title="" class="btn btn-primary" data-original-title="Обновить"><i class="fa fa-sync "></i></button>
                                    <a title="Удалить" class="btn btn-danger" href="<?= Url::to(['remove', 'id' => $item->getId()]) ?>" data-method="post"><i class="fa fa-times-circle"></i></a>
                                </span>
                        </div>
                        <?= Html::endForm() ?>
                    </td>
                    <td class="text-right"><?= PriceHelper::format($item->getPrice()) ?></td>
                    <td class="text-right"><?= PriceHelper::format($item->getCost()) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <br />
    <div class="row">
        <div class="col-sm-4 col-sm-offset-8">
            <?php $cost = $cart->getCost() ?>
            <table class="table table-bordered">
                <tr>
                    <td class="text-right"><strong>Предварительная цена:</strong></td>
                    <td class="text-right"><?= PriceHelper::format($cost->getOrigin()) ?></td>
                </tr>
                <?php foreach ($cost->getDiscounts() as $discount): ?>
                    <tr>
                        <td class="text-right"><small>Скидка</small>&nbsp;&nbsp;&laquo;<strong><?= Html::encode($discount->getName()) ?></strong>&raquo; :</td>
                        <td class="text-right"><?= PriceHelper::format($discount->getValue()) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="text-right"><strong>Итого:</strong></td>
                    <td class="text-right"><?= PriceHelper::format($cost->getTotal()) ?></td>
                </tr>
                <!--<tr>
                    <td class="text-right"><strong>Вес:</strong></td>
                    <td class="text-right"><?/*= WeightHelper::format($cart->getWeight()) */?></td>
                </tr>-->
            </table>
        </div>
    </div>
    <p class="text-right">
        <a href="<?= Url::to(['/shop/cart/clear']) ?>" class="text-danger" data-method="post">
            <strong><i class="fas fa-times-circle"></i> Очистить корзину</strong>
        </a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?= Url::to(['/shop/catalog/index']) ?>" class="text-danger">
            <strong><i class="fa fa-shopping-basket" ></i> Продолжить покупки</strong>
        </a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?= Url::to(['/shop/checkout/index']) ?>"  class="text-danger">
            <strong><i class="fa fa-share"></i> Оформить заказ</strong>
        </a>
    </p>
</div>
