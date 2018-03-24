<?php

namespace store\entities\shop\product\queries;


use store\entities\shop\product\Product;
use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias  .'.' : '') . 'status' => Product::STATUS_ACTIVE,
        ]);
    }
}