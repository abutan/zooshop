<?php

namespace store\frontModels\shop;


use store\entities\shop\Category;
use yii\helpers\ArrayHelper;

class CategoryReadRepository
{
    private $products;

    public function __construct(ProductReadRepository $products)
    {
        $this->products = $products;
    }

    public function getRoot(): Category
    {
        return Category::find()->roots()->one();
    }

    /**
     * @return Category[]
     */
    public function getAll(): array
    {
        return Category::find()->andWhere(['>', 'depth', 0])->orderBy('lft')->all();
    }

    public function find($id): ?Category
    {
        return Category::findOne($id);
    }

    public function findBySlug($slug): ?Category
    {
        return Category::findOne(['slug' => $slug]);
    }

    public function getTreeWithSubsOf(Category $category = null)
    {
        $query = Category::find()->andWhere(['>', 'depth', 0])->orderBy('lft');
        if ($category){
            $criteria = ['or',['depth' => 1]];
            foreach (ArrayHelper::merge([$category], $category->parents) as $item){
                $criteria[] = ['and', ['>', 'lft', $item->lft], ['<', 'rgt', $item->rgt], ['depth' => $item->depth + 1]];
            }
            $query->andWhere($criteria);
        }else{
            $query->andWhere(['depth' => 1]);
        }

        return $query->all();
    }
}