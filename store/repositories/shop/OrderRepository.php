<?php

namespace store\repositories\shop;


use store\entities\shop\order\Order;
use yii\web\NotFoundHttpException;

class OrderRepository
{
    public function get($id): Order
    {
        if (!$order = Order::findOne($id)){
            throw new NotFoundHttpException('Заказ не найден.');
        }
        return $order;
    }

    public function save(Order $order): void
    {
        if (!$order->save()){
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Order $order): void
    {
        if (!$order->delete()){
            throw new \RuntimeException('Ошибка удаления');
        }
    }
}