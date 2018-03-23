<?php

namespace store\repositories\manage\shop;


use store\entities\shop\DeliveryMethod;
use yii\web\NotFoundHttpException;

class DeliveryRepository
{
    public function get($id): DeliveryMethod
    {
        if (!$method = DeliveryMethod::findOne($id)){
            throw new NotFoundHttpException('Метод не найден.');
        }
        return $method;
    }

    public function findByName($name)
    {
        return DeliveryMethod::findOne(['name' => $name]);
    }

    public function save(DeliveryMethod $method)
    {
        if (!$method->save()){
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DeliveryMethod $method)
    {
        if (!$method->delete()){
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}