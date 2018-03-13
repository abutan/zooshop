<?php

namespace store\forms\manage\shop\product;


use store\entities\shop\Characteristic;
use store\entities\shop\product\ProductValue;
use yii\base\Model;

class ProductValueForm extends Model
{
    public $characteristicId;
    public $text;

    private $_characteristic;

    public function __construct(Characteristic $characteristic, ProductValue $value = null, array $config = [])
    {
        if ($value){
            $this->text = $value->value;
        }
        $this->_characteristic = $characteristic;
        $this->characteristicId = $this->_characteristic->id;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['characteristicId', 'required'],
            ['characteristicId', 'integer'],
            ['text', 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => $this->_characteristic->name,
        ];
    }
}