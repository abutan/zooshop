<?php

namespace store\repositories\manage\shop;


use store\entities\shop\Maker;
use yii\web\NotFoundHttpException;

class MakerRepository
{
    public function get($id): Maker
    {
        if (!$maker = Maker::findOne($id)){
            throw new NotFoundHttpException('Производитель не найден.');
        }
        return $maker;
    }

    public function save(Maker $maker)
    {
        if (!$maker->save()){
            throw new \DomainException('Ошибка сохранения');
        }
    }

    public function remove(Maker $maker)
    {
        if (!$maker->delete()){
            throw new \DomainException('Ошибка удаления.');
        }
    }
}