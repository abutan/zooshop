<?php

namespace store\repositories\manage\shop;


use store\entities\shop\product\Product;
use yii\web\NotFoundHttpException;

class ProductRepository
{
    public function get($id): Product
    {
        if (!$product = Product::findOne($id)){
            throw new NotFoundHttpException('Товар не найден.');
        }
        return $product;
    }

    public function existsByBrand($id): bool
    {
        return Product::find()->andWhere(['brand_id' => $id])->exists();
    }

    public function existsByCategory($id): bool
    {
        return Product::find()->andWhere(['category_id' => $id])->exists();
    }

    public function existsByMaker($id): bool
    {
        return Product::find()->andWhere(['maker_id' => $id])->exists();
    }

    public function save(Product $product): void
    {
        if (!$product->save()){
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Product $product): void
    {
        if (!$product->delete()){
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}