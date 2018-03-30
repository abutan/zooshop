<?php

/* @var $this \yii\web\View */
/* @var $model \store\forms\shop\order\OrderForm */
/* @var $cart \store\cart\Cart */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;
use store\helpers\PriceHelper;

$this->title = 'Оформление заказа';

$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/shop/catalog/index']];
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/shop/cart/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-index container-fluid">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-left">Название товара</th>
                    <th class="text-left">Модель</th>
                    <th class="text-left">Количество</th>
                    <th class="text-right">Цена за единицу</th>
                    <th class="text-right">Всего</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart->getItems() as $item): ?>
                <?php $product = $item->getProduct() ?>
                <?php $modification = $item->getModification() ?>
                <?php $url = Url::to(['shop/catalog/product', 'id' => $product->id]) ?>
                    <tr>
                        <td class="text-left">
                            <a href="<?= $url ?>">
                                <?= Html::encode($product->name) ?>
                            </a>
                        </td>
                        <td class="text-left">
                            <?php if ($modification): ?>
                                <?= $modification->name ?>
                            <?php endif; ?>
                        </td>
                        <td class="text-left">
                            <?= $item->getQuantity() ?>
                        </td>
                        <td class="text-right">
                            <?= PriceHelper::format($item->getPrice()) ?>
                        </td>
                        <td class="text-right">
                            <?= PriceHelper::format($item->getCost()) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <br>
    <?php $cost = $cart->getCost() ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <td><strong>Предварительная цена</strong></td>
                <td class="text-right"><?= PriceHelper::format($cost->getOrigin()) ?></td>
            </tr>
            <?php foreach ($cost->getDiscounts() as $discount): ?>
                <tr>
                    <td><small>Скидка</small>&nbsp;&nbsp;&laquo;<strong><?= Html::encode($discount->getName()) ?></strong>&raquo; :</td>
                    <td class="text-right"><?= PriceHelper::format($discount->getValue()) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td><strong>Итого</strong></td>
                <td class="text-right"><strong><?= PriceHelper::format($cost->getTotal()) ?></strong></td>
            </tr>
            </tbody>
        </table>
    </div>

    <?php $form = ActiveForm::begin() ?>
    <div class="panel panel-default">
        <div class="panel-heading">Данные покупателя</div>
        <div class="panel-body">
            <?= $form->field($model, 'customerName')->textInput(['maxlength' => true, 'placeholder' => 'ФИО']) ?>
            <?= $form->field($model, 'customerPhone')->widget(MaskedInput::class, [
                'mask' => '+7 (999) 999 - 99 - 99',
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'Контактный телефон',
                ],
            ]) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Доставка</div>
        <div class="panel-body">
            <?= $form->field($model->delivery, 'method')->dropDownList($model->delivery->deliveryMethodsList(), ['prompt' => ' --- Выберите ---  ']) ?>
            <?= $form->field($model->delivery, 'index')->widget(MaskedInput::class, [
                'mask' => '9 9 9 9 9 9',
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'Почтовый индекс',
                ],
            ]) ?>
            <?= $form->field($model->delivery, 'address')->textarea(['rows' => 3, 'placeholder' => 'Адрес доставки'])->hint('Напишите адрес доставки, примерно, в следующем виде - Россия, Ростов-на-Дону, ул. Ленина 22, кв. 5') ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Способ оплаты</div>
        <div class="panel-body">
            <?= $form->field($model, 'payment')->dropDownList($model->paymentList(), ['prompt' => ' --- Выберите --- ']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Комментарий к заказу</div>
        <div class="panel-body">
            <?= $form->field($model, 'note')->textarea(['rows' => 3, 'placeholder' => 'Ваш комментарий'])->hint('Напишите что по Вашему мнению поможет нам ускорить доставку - ориентиры, домофон, этаж и т.п.') ?>
        </div>
    </div>

    <div class="form-group">
        <?=Html::submitButton('Оформить заказ', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
