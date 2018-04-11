<?php
/* @var $this \yii\web\View */
/* @var $order \store\entities\shop\order\Order */
/* @var string $userName */
?>

<div class="order-sent">
    <p>
        Здравствуйте <?= $userName ?>!
    </p>
    <p>
        Сообщаем Вам, что Ваш <strong>ЗАКАЗ №<?= $order->id ?></strong> отправлен.
    </p>
    <p>
        Подробности и историю Ваших заказов можно посмотреть на сайте в Вашем личном кабинете в разделе "ИСТОРИЯ ЗАКАЗОВ".
    </p>
    <p>
        Команда сайта &laquo;Дежурная ветаптека&raquo;.
    </p>
</div>