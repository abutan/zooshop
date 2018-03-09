<?php

namespace store\repositories\manage\shop;


use store\entities\shop\Category;
use yii\web\NotFoundHttpException;

class CategoryRepository
{
    public function get($id): Category
    {
        if (!$category = Category::findOne($id)){
            throw new NotFoundHttpException('Категория не найдена');
        }
        return $category;
    }

    public function save(Category $category)
    {
        if (!$category->save()){
            throw new \RuntimeException('Ошибка сохранения');
        }
    }

    public function remove(Category $category)
    {
        if (!$category->delete()){
            throw new \RuntimeException('Ошибка удаления');
        }
    }
}