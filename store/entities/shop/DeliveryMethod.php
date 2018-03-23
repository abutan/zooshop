<?php

namespace store\entities\shop;


use store\entities\shop\queries\DeliveryMethodQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property int $cost [int(11)]
 * @property int $min_price [int(11)]
 * @property int $max_price [int(11)]
 * @property int $min_weight [int(11)]
 * @property int $max_weight [int(11)]
 * @property int $sort [int(11)]
 */
class DeliveryMethod extends ActiveRecord
{
    public static function create($name, $cost, $minPrice, $maxPrice, $minWeight, $maxWeight, $sort): self
    {
        $method = new static();
        $method->name = $name;
        $method->cost = $cost;
        $method->min_price = $minPrice;
        $method->max_price = $maxPrice;
        $method->min_weight = $minWeight;
        $method->max_weight = $maxWeight;
        $method->sort = $sort;

        return $method;
    }

    public function edit($name, $cost, $minPrice, $maxPrice, $minWeight, $maxWeight, $sort)
    {
        $this->name = $name;
        $this->cost = $cost;
        $this->min_price = $minPrice;
        $this->max_price = $maxPrice;
        $this->min_weight = $minWeight;
        $this->max_weight = $maxWeight;
        $this->sort = $sort;
    }

    public function attributeLabels() {
        return [
            'name' => 'Название метода',
            'cost' => 'Стоимость доставки',
            'min_price' => 'Минимальная сумма заказа',
            'minPrice' => 'Минимальная сумма заказа',
            'max_price' => 'Максимальная сумма заказа',
            'maxPrice' => 'Максимальная сумма заказа',
            'min_weight' => 'Минимальный вес заказа',
            'minWeight' => 'Минимальный вес заказа',
            'max_weight' => 'Максимальный вес заказа',
            'maxWeight' => 'Максимальный вес заказа',
            'sort' => 'Порядковый номер',
        ];
    }

    public function isAvailableForDeliveryMethod($weight, $price)
    {
        return (!$this->min_weight || $this->min_weight <= $weight) && (!$this->min_price || $this->min_price <= $price) && (!$this->max_weight || $weight <= $this->max_weight) && (!$this->max_price || $price <= $this->max_price);
    }

    public static function find(): DeliveryMethodQuery
    {
        return new DeliveryMethodQuery(static::class);
    }

    public static function tableName() {
        return '{{%shop_delivery_methods}}';
    }
}