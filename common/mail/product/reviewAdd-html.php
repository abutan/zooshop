<?php
/* @var $this \yii\web\View */
/* @var $product \store\entities\shop\product\Product */

use yii\helpers\Html;

$url = Yii::$app->get('frontendUrlManager')->createAbsoluteUrl(['shop/catalog/product', 'id' => $product->id]);
?>

<div class="review-add">
    <p>
        Здравствуй админ.
    </p>
    <p>
        Обрати внимание! Добавлен комментарий к товару <?= Html::a(Html::encode($product->name), $url) ?>. Проверь комментарий и активируй его, чтобы посчитался рейтинг к этому товару.
    </p>
    <p>
        Сайт "Дежурная ветаптека".
    </p>
</div>
