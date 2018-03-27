<?php

/* @var $this \yii\web\View */
/* @var $cart \store\cart\Cart */

use yii\helpers\Url;
use yii\helpers\Html;
use store\helpers\PriceHelper;


?>

<div id="vetshop-cart" class="btn-group btn-block">
    <?php if ($cart->getAmount() == 0): ?>
        <button type="button" class="vetshop-cart">
            <i class="fa fa-shopping-cart hidden-sm"></i> Корзина пуста
        </button>
    <?php else: ?>
        <button type="button" data-toggle="dropdown" data-loading-text="Загрузка ..." class="dropdown-toggle vetshop-cart" aria-expanded="false">
            <i class="fa fa-shopping-cart hidden-sm"></i>
            <span id="cart-total">
            <?=  $cart->getAmount()?> товар(а, ов) - <?= $cart->getCost()->getTotal() ?> <span class="glyphicon glyphicon-rub"></span>
        </span>
        </button>
    <ul id="dropdown-cart" class="dropdown-menu pull-right">
        <li>
            <table class="table table-striped table-hover">
                <?php foreach ($cart->getItems() as $item): ?>
                    <?php
                    $product = $item->getProduct();
                    $modification = $item->getModification();
                    $url = Url::to(['/shop/catalog/product', 'id' => $product->id]);
                    ?>
                    <tr>
                        <td class="text-center td-image">
                            <?php if ($product->main_photo_id): ?>
                                <img src="<?= $product->mainPhoto->getThumbFileUrl('file', 'full') ?>" alt="<?= $product->name ?>" class="img-responsive" />
                            <?php endif; ?>
                        </td>
                        <td class="text-left">
                            <a href="<?= $url ?>"><?= Html::encode($product->name) ?></a>
                            <?php if ($modification): ?>
                                <br/><small><?= Html::encode($modification->name) ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="text-right">x <?= $item->getQuantity() ?></td>
                        <td class="text-right"><?= PriceHelper::format($item->getCost()) ?></td>
                        <td class="text-center">
                            <a href="<?= Url::to(['/shop/cart/remove', 'id' => $item->getId()]) ?>" title="Удалить" class="btn btn-danger btn-xs" data-method="post"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </li>
        <li>
            <div>
                <?php $cost = $cart->getCost(); ?>
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
                </table>
                <p class="text-right">
                    <a href="<?= Url::to(['/shop/catalog/index']) ?>">
                        <strong><i class="fa fa-shopping-basket" ></i> Продолжить покупки</strong>
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="<?= Url::to(['/shop/cart/index']) ?>">
                        <strong><i class="fa fa-shopping-cart"></i> Перейти в корзину</strong>
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="<?= Url::to(['/shop/checkout/index']) ?>">
                        <strong><i class="fa fa-share"></i> Оформить заказ</strong>
                    </a>
                </p>
            </div>
        </li>
    </ul>
<?php endif; ?>
</div>

