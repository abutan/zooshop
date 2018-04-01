<?php

namespace store\forms\manage\shop\product;


use store\entities\shop\Characteristic;
use store\entities\shop\product\ModificationValue;
use yii\base\Model;

class ModificationValueForm extends Model
{
    public $characteristicId;
    public $value;

    private $_characteristic;

    public function __construct(Characteristic $characteristic, ModificationValue $value = null, array $config = [])
    {
        if ($value){
            $this->value = $value->value;
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
            ['value', 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'value' => $this->_characteristic->name,
        ];
    }
}