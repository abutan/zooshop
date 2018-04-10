<?php
/* @var $this \yii\web\View */
/* @var $user \store\entities\user\User */
/* @var $product \store\entities\shop\product\Product */

$url = Yii::$app->get('frontendUrlManager')->createAbsoluteUrl(['shop/catalog/product', 'id' => $product->id]);
?>

Здравствуй админ!

Пользователь <?= $user->username ?> добавил в свой лист желаний (вишлист, избранное) <?= $url ?> .
