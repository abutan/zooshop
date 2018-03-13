<?php

namespace store\forms\manage\shop\product;


use store\entities\shop\product\Product;
use yii\base\Model;

class QuantityForm extends Model
{
    public $quantity;

    public function __construct(Product $product = null, array $config = [])
    {
        if ($product){
            $this->quantity = $product->quantity;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['quantity', 'required'],
            ['quantity', 'integer', 'min' => 0],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'quantity' => 'Количество на складе',
        ];
    }
}