<?php

namespace store\repositories\manage\shop;


use store\entities\shop\Tag;
use yii\web\NotFoundHttpException;

class TagRepository
{
    public function get($id): Tag
    {
        if (!$tag = Tag::findOne($id)){
            throw new NotFoundHttpException('Таг не найден');
        }
        return $tag;
    }

    public function findByName($name)
    {
        return Tag::findOne(['name' => $name]);
    }

    public function save(Tag $tag)
    {
        if (!$tag->save()){
            throw new \RuntimeException('Ошибка сщхранения');
        }
    }

    public function remove(Tag $tag)
    {
        if (!$tag->delete()){
            throw new \RuntimeException('Ошибка удаления');
        }
    }
}