<?php

namespace store\forms\manage\shop\product;


use store\entities\shop\product\Product;
use yii\base\Model;

class PriceForm extends Model
{
    public $old;
    public $new;

    public function __construct(Product $product = null, array $config = [])
    {
        if ($product){
            $this->old = $product->price_old;
            $this->new = $product->price_new;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['new', 'required'],
            [['new', 'old'], 'integer', 'min' => 0],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'old' => 'Старая цена',
            'new' => 'Цена',
        ];
    }
}