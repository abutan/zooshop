<?php

namespace store\frontModels\shop;


use store\entities\shop\Brand;
use yii\helpers\ArrayHelper;

class BrandReadRepository
{
    public function findBiId($id): ?Brand
    {
        return Brand::findOne($id);
    }

    public function findBySlug($slug): ?Brand
    {
        return Brand::findOne(['slug' => $slug]);
    }

    public function getToSelect(): array
    {
        return ArrayHelper::map(Brand::find()->all(), 'id', 'name');
    }
}