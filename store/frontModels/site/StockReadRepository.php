<?php

namespace store\frontModels\site;


use store\entities\site\Stock;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class StockReadRepository
{
    public function getAll(): DataProviderInterface
    {
        $query = Stock::find()->andWhere(['status' => 1]);
        return $this->getProvider($query);
    }

    public function findBySlug($slug): ?Stock
    {
        return Stock::find()->andWhere(['slug' => $slug])->andWhere(['status' => 1])->one();
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);
    }
}