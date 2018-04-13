<?php

namespace store\frontModels\shop;


use store\entities\shop\Brand;
use store\entities\shop\Category;
use store\entities\shop\Maker;
use store\entities\shop\product\Product;
use store\entities\shop\Tag;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class ProductReadRepository
{
    public function count(): int
    {
        return Product::find()->active()->count();
    }

    public function getAll(): DataProviderInterface
    {
        $query = Product::find()->alias('p')->active('p')->with('mainPhoto');
        return $this->getProvider($query);
    }

    public function getAllByRange(int $offset, int $limit): array
    {
        return Product::find()->alias('p')->active('p')->orderBy(['id' => SORT_ASC])->limit($limit)->offset($offset)->all();
    }

    public function getAllIterator(): iterable
    {
        return Product::find()->active()->with('mainPhoto', 'brand', 'maker')->each();
    }

    public function getAllByCategory(Category $category): DataProviderInterface
    {
        $query = Product::find()->alias('p')->active('p')->with(['mainPhoto', 'category']);
        $idx = ArrayHelper::merge([$category->id], $category->getDescendants()->select('id')->column());
        $query->joinWith(['categoryAssignments ca'], false);
        $query->andWhere(['or', ['p.category_id' => $idx], ['ca.category_id' => $idx]]);
        $query->groupBy('p.id');

        return $this->getProvider($query);
    }

    public function getAllByBrand(Brand $brand): DataProviderInterface
    {
        $query = Product::find()->alias('p')->active('p')->with('mainPhoto');
        $query->andWhere(['brand_id' => $brand->id]);
        return $this->getProvider($query);
    }

    public function getAllByMaker(Maker $maker): DataProviderInterface
    {
        $query = Product::find()->alias('p')->active('p')->with('mainPhoto');
        $query->andWhere(['maker_id' => $maker->id]);
        return $this->getProvider($query);
    }

    public function getAllByTag(Tag $tag): DataProviderInterface
    {
        $query = Product::find()->alias('p')->active('p')->with('mainPhoto');
        $query->joinWith(['tagAssignments ta'], false);
        $query->andWhere(['ta.tag_id' => $tag->id]);
        $query->groupBy('p.id');
        return $this->getProvider($query);
    }

    public function find($id): ?Product
    {
        return Product::findOne($id);
    }

    public function findBySlug($slug): ?Product
    {
        return Product::findOne(['slug' => $slug]);
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
                'attributes' => [
                    'id' => [
                        'asc' => ['p.id' => SORT_ASC],
                        'desc' => ['p.id' => SORT_DESC],
                    ],
                    'name' => [
                        'asc' => ['p.name' => SORT_ASC],
                        'desc' => ['p.name' => SORT_DESC],
                    ],
                    'price' => [
                        'asc' => ['p.price_new' => SORT_ASC],
                        'desc' => ['p.price_new' => SORT_DESC],
                    ],
                ],
            ],
            'pagination' => [
                'pageSizeLimit' => [15, 100],
                'defaultPageSize' => 15,
            ],
        ]);
    }

    public function getCount(Category $category): int
    {
        $query = Product::find()->alias('p')->active('p')->with('category');
        $idx = ArrayHelper::merge([$category->id], $category->getDescendants()->select('id')->column());
        $query->joinWith(['categoryAssignments ca'], false);
        $query->andWhere(['or', ['p.category_id' => $idx], ['ca.category_id' => $idx]]);
        $query->groupBy('p.id');
        $themes = $this->getProvider($query);
        return $themes->getTotalCount();
    }

    public function getWhishlist($userId): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Product::find()
                ->alias('p')->active('p')
                ->joinWith('wishlistItems w', false, 'INNER JOIN')
                ->andWhere(['w.user_id' => $userId]),
            'sort' => false,
        ]);
    }

    public function getSaleList(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Product::find()
                ->active()
                ->andWhere(['sale' => 1]),
            'sort' => false,
            'pagination' => [
                'pageSizeLimit' => [15, 100],
                'defaultPageSize' => 15,
            ],
        ]);
    }

    public function getRelatesProducts($id): ActiveDataProvider
    {
        $product = Product::findOne($id);
        $idx = ArrayHelper::getColumn($product->relates, 'id');
        return new ActiveDataProvider([
            'query' => Product::find()
                ->alias('p')
                ->active('p')
                ->with('mainPhoto')
                ->andWhere(['p.id' => $idx]),
            'sort' => false,
            'pagination' => false,
        ]);
    }

    public function searchByText($text): ActiveDataProvider
    {
        $query = Product::find()->active()->andWhere(['like', 'name', $text]);
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'id' => [
                        'asc' => ['id' => SORT_ASC],
                        'desk' => ['id' => SORT_DESC],
                    ],
                    'name' => [
                        'asc' => ['name' => SORT_ASC],
                        'desc' => ['name' => SORT_DESC],
                    ],
                    'price' => [
                        'asc' => ['price_new' => SORT_ASC],
                        'desc' => ['price_new' => SORT_DESC],
                    ],
                    'rating' => [
                        'asc' => ['rating' => SORT_ASC],
                        'desc' => ['rating' => SORT_DESC],
                    ],
                ],
            ],
            'pagination' => [
                'pageSizeLimit' => [15, 100],
                'defaultPageSize' => 15,
            ],
        ]);
    }

    public function searchByWidget($maker, $brand, $tag): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Product::find()
                ->alias('p')->active('p')
                ->with('mainPhoto')
                ->andFilterWhere(['maker_id' => $maker])
                ->andFilterWhere(['brand_id' => $brand])
                ->joinWith('tagAssignments ta', false)
                ->andFilterWhere(['ta.tag_id' => $tag])
                ->groupBy('p.id'),
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'id' => [
                        'asc' => ['id' => SORT_ASC],
                        'desk' => ['id' => SORT_DESC],
                    ],
                    'name' => [
                        'asc' => ['name' => SORT_ASC],
                        'desc' => ['name' => SORT_DESC],
                    ],
                    'price' => [
                        'asc' => ['price_new' => SORT_ASC],
                        'desc' => ['price_new' => SORT_DESC],
                    ],
                ],
            ],
            'pagination' => [
                'pageSizeLimit' => [15, 100],
                'defaultPageSize' => 15,
            ],
        ]);
    }

    public function getFeatured($limit)
    {
        return Product::find()->with('mainPhoto')->active()->orderBy(['id' => SORT_DESC])->limit($limit)->all();
    }

    public function getHits($limit)
    {
        return Product::find()->with('mainPhoto')->active()->orderBy(['rating' => SORT_DESC])->limit($limit)->all();
    }
}