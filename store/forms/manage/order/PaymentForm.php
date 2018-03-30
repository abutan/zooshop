<?php

namespace store\forms\manage\order;


use store\entities\shop\order\PaymentMethod;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class PaymentForm extends Model
{
    public $name;

    private $_method;

    public function __construct(PaymentMethod $method = null, array $config = [])
    {
        if ($method){
            $this->name = $method->name;
            $this->_method = $method;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['name', 'unique', 'targetClass' => PaymentMethod::class, 'message' => 'Такое название метода уже используется.', 'filter' => $this->_method ? ['<>', 'id', $this->_method->id] : null],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название метода',
        ];
    }

    public function paymentList(): array
    {
        return ArrayHelper::map(PaymentMethod::find()->all(), 'id', 'name');
    }
}