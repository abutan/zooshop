<?php

namespace store\forms\manage\shop\product;


use store\entities\shop\Category;
use store\entities\shop\product\Product;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ProductRelatesForm extends Model
{
    public $products = [];

    public function __construct(Product $product = null, array $config = [])
    {
        if ($product){
            $this->products = ArrayHelper::getColumn($product->relatedAssignments, 'related_id');
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['products', 'each', 'rule' => ['integer']],
            ['products', 'default', 'value' => []],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'products' => 'Сопутствующие товары',
        ];
    }

    public function relatedList(): array
    {
        return ArrayHelper::map(Product::find()->active()->all(), 'id', 'name');
    }
}