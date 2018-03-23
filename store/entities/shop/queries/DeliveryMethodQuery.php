<?php

namespace store\entities\shop\queries;


use yii\db\ActiveQuery;

class DeliveryMethodQuery extends ActiveQuery
{
    public function availableForDeliveryMethod($weight, $price)
    {
        return $this->andWhere([
            'and',
            ['or', ['min_weight' => NULL], [ '<=' ,'min_weight', $weight]],
            ['or', ['max_weight' => NULL], ['>=', 'max_weight', $weight ]],
            ['or', ['min_price' => NULL], ['<=', 'min_price', $price]],
            ['or', ['max_price' => NULL], ['>=', 'max_price', $price]],
        ]);
    }
}