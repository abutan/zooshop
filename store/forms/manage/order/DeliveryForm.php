<?php

namespace store\forms\manage\order;


use store\entities\shop\DeliveryMethod;
use store\entities\shop\order\Order;
use store\helpers\PriceHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DeliveryForm extends Model
{
    public $method;
    public $address;
    public $index;

    public function __construct(Order $order, array $config = [])
    {
        $this->method = $order->delivery_method_id;
        $this->index = $order->delivery_index;
        $this->address = $order->delivery_address;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['address'], 'required'],
            ['index', 'string', 'max' => 255],
            ['method', 'integer'],
            ['address', 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'method' => 'Способ доставки',
            'index' => 'Почтовый индекс',
            'address' => 'Адрес доставки',
        ];
    }

    public function deliveryMethodList()
    {
        $methods = DeliveryMethod::find()->orderBy('sort')->all();

        return ArrayHelper::map($methods, 'id', function (DeliveryMethod $method){
            return $method->name . '(' . $method->cost . ' руб)';
        });
    }
}