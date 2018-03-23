<?php

namespace store\repositories\manage\shop;


use store\entities\shop\Discount;
use yii\web\NotFoundHttpException;

class DiscountRepository
{
    public function get($id): Discount
    {
        if (!$discount = Discount::findOne($id)){
            throw new NotFoundHttpException('Скидка не найдена.');
        }
        return $discount;
    }

    public function save(Discount $discount): void
    {
        if (!$discount->save()){
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Discount $discount): void
    {
        if (!$discount->delete()){
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}