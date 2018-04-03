<?php

namespace store\frontModels\site;


use store\entities\site\Bonus;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;

class BonusReadRepository
{
    public function getAll(): DataProviderInterface
    {
        $query = Bonus::find()->andWhere(['status' => 1]);
        return $this->getProvider($query);
    }

    public function findBySlug($slug): ?Bonus
    {
        return Bonus::find()->andWhere(['status' => 1])->andWhere(['slug' => $slug])->one();
    }

    private function getProvider($query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
    }
}