<?php

namespace store\frontModels\shop;


use store\entities\shop\Maker;
use yii\helpers\ArrayHelper;

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

    public function getToSelect(): array
    {
        return ArrayHelper::map(Maker::find()->all(), 'id', 'name');
    }
}