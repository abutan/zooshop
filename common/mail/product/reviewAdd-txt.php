<?php
/* @var $this \yii\web\View */
/* @var $product \store\entities\shop\product\Product */

$url = Yii::$app->get('frontendUrlManager')->createAbsoluteUrl(['shop/catalog/product', 'id' => $product->id]);
?>

Здравствуй админ.
Обрати внимание! Добавлен комментарий к товару <?= $url ?>. Проверь комментарий и активируй его, чтобы посчитался рейтинг к этому товару.
Сайт "Дежурная ветаптека".
