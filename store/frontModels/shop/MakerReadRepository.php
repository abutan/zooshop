<?php

namespace store\frontModels\shop;


use store\entities\shop\Maker;

class MakerReadRepository
{
    public function findById($id): ?Maker
    {
        return Maker::findOne($id);
    }

    public function findBySlug($slug): ?Maker
    {
        return Maker::findOne(['slug' => $slug]);
    }
}