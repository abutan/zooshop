<?php

namespace store\frontModels\site;


use store\entities\site\Notification;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class NotificationReadRepository
{
    public function getAll(): DataProviderInterface
    {
        $query = Notification::find();
        return $this->getProvider($query);
    }

    public function findBySlug($slug): ?Notification
    {
        return Notification::find()->andWhere(['slug' => $slug])->one();
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