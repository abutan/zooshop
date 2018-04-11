<?php
/* @var $this \yii\web\View */
/* @var $order \store\entities\shop\order\Order */
/* @var string $userName */
?>

<div class="order-create">
    <p>
        Здравствуй админ.
    </p>
    <p>
        Довожу до твоего сведения что пользователь &laquo;<?= $userName ?>&raquo; сделал заказ на сайте. <br>
        Номер заказа - <?= $order->id ?>.
    </p>
    <p>
        Сайт "Дежурная ветаптека".
    </p>
</div>
