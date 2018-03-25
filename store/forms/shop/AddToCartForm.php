<?php

namespace store\forms\shop;


use store\entities\shop\product\Modification;
use store\entities\shop\product\Product;
use store\helpers\PriceHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AddToCartForm extends Model
{
    public $modification;
    public $quantity;

    private $_product;

    public function __construct(Product $product, $config = [])
    {
        $this->_product = $product;
        $this->quantity = 1;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return array_filter([
            $this->_product->modifications ? ['modification', 'integer'] : false,
            ['quantity', 'required'],
            ['quantity', 'integer', 'max' => $this->_product->quantity],
        ]);
    }

    public function modificationsList(): array
    {
        return ArrayHelper::map($this->_product->modifications, 'id', function (Modification $modification) {
            return $modification->code . ' - ' . $modification->name . ' (' . PriceHelper::format($modification->price ?: $this->_product->price_new) . ')';
        });
    }
}