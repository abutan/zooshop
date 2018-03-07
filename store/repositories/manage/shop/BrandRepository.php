<?php

namespace store\repositories\manage\shop;


use store\entities\shop\Brand;
use yii\web\NotFoundHttpException;

class BrandRepository
{
    public function get($id):Brand
    {
        if (!$brand = Brand::findOne($id)){
            throw new NotFoundHttpException('Бренд не найден');
        }
        return $brand;
    }

    public function save(Brand $brand)
    {
        if (!$brand->save())
        {
            throw new \RuntimeException('Ошибка сохранения');
        }
    }

    public function remove(Brand $brand)
    {
        if (!$brand->delete()){
            throw new \RuntimeException('Ошибка удаления');
        }
    }
}