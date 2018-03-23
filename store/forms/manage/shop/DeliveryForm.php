<?php

namespace store\forms\manage\shop;


use store\entities\shop\DeliveryMethod;
use yii\base\Model;

class DeliveryForm extends Model
{
    public $name;
    public $cost;
    public $minPrice;
    public $maxPrice;
    public $minWeight;
    public $maxWeight;
    public $sort;

    public function __construct(DeliveryMethod $method = NULL, array $config = []) {
        if ($method){
            $this->name = $method->name;
            $this->cost = $method->cost;
            $this->minPrice = $method->min_price;
            $this->maxPrice = $method->max_price;
            $this->minWeight = $method->min_weight;
            $this->maxWeight = $method->max_weight;
            $this->sort = $method->sort;
        }else{
            $this->sort = DeliveryMethod::find()->max('sort') + 1;
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            [['name', 'cost', 'sort'], 'required'],
            ['name', 'string', 'max' => 255],
            [['cost', 'minPrice', 'minWeight', 'maxPrice', 'maxWeight', 'sort'], 'integer'],
        ];
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
}