<?php

namespace store\forms\shop\order;


use store\entities\shop\DeliveryMethod;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use store\helpers\PriceHelper;

class DeliveryForm extends Model
{
    public $method;
    public $address;
    public $index;

    private $_price;
    private $_weight;

    public function __construct($price, int $weight, array $config = [])
    {
        parent::__construct($config);
        $this->_price = $price;
        $this->_weight = $weight;
    }

    public function rules(): array
    {
        return [
            [['index', 'address'], 'required'],
            ['method', 'integer'],
            ['index', 'string', 'max' => 255],
            ['address', 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'method' => 'Метод доставки',
            'index' => 'Почтовый индекс',
            'address' => 'Адрес доставки',
        ];
    }

    public function deliveryMethodsList(): array
    {
        $methods = DeliveryMethod::find()->availableForDeliveryMethod($this->_weight, $this->_price)->orderBy('sort')->all();
        return ArrayHelper::map($methods, 'id', function (DeliveryMethod $method){
           return $method->name . '(' . $method->cost . 'руб)';
        });
    }
}