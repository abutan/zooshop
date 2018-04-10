<?php
/* @var $this \yii\web\View */
/* @var $user \store\entities\user\User */
/* @var $product \store\entities\shop\product\Product */

use yii\helpers\Html;
$url = Yii::$app->get('frontendUrlManager')->createAbsoluteUrl(['shop/catalog/product', 'id' => $product->id]);
?>

<div class="whishlist-add">
    <p>
        Здравтвуй админ!
    </p>
    <p>
        Обрати внимание! Пользователь <?= $user->username ?> добавил в свой лист желаний (вишлист, избранное) <?= Html::a(Html::encode($product->name), $url) ?>
    </p>
    <p>
        Сайт "Дежурная ветаптека".
    </p>
</div>


