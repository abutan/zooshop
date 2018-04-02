<?php

namespace store\repositories\site;


use store\entities\site\Stock;
use yii\web\NotFoundHttpException;

class StockRepository
{
    public function get($id): Stock
    {
        if (!$Stock = Stock::findOne($id)){
            throw new NotFoundHttpException('Такой комментарий не найден.');
        }
        return $Stock;
    }

    public function save(Stock $Stock)
    {
        if (!$Stock->save()){
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Stock $Stock)
    {
        if (!$Stock->delete()){
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}