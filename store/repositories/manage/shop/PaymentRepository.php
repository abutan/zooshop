<?php

namespace store\repositories\manage\shop;


use store\entities\shop\order\PaymentMethod;
use yii\web\NotFoundHttpException;

class PaymentRepository
{
    public function get($id): PaymentMethod
    {
        if (!$method = PaymentMethod::findOne($id)){
            throw new NotFoundHttpException('Метод не найден.');
        }
        return $method;
    }

    public function save(PaymentMethod $method): void
    {
        if (!$method->save()){
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(PaymentMethod $method): void
    {
        if (!$method->delete()){
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}