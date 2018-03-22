<?php

namespace store\frontModels\shop;


use store\entities\shop\Brand;

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
}