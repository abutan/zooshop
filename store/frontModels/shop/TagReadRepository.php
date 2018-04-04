<?php

namespace store\frontModels\shop;


use store\entities\shop\Tag;
use yii\helpers\ArrayHelper;

class TagReadRepository
{
    public function findById($id): ?Tag{
        return Tag::findOne($id);
    }

    public function findBySlug($slug): ?Tag
    {
        return Tag::findOne(['slug' => $slug]);
    }

    public function getToSelect(): array
    {
        return ArrayHelper::map(Tag::find()->all(), 'id', 'name');
    }
}