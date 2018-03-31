<?php

namespace store\forms\manage\shop\product;

use store\entities\shop\Characteristic;
use store\entities\shop\product\ProductValue;
use yii\base\Model;

/* @property int $id */

class ProductValueForm extends Model
{
    public $text;

    private $_characteristic;

    public function __construct(Characteristic $characteristic, ProductValue $value = null, array $config = [])
    {
        if ($value){
            $this->text = $value->value;
        }
        $this->_characteristic = $characteristic;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['text', 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => $this->_characteristic->name,
        ];
    }

    public function getId(): int
    {
        return $this->_characteristic->id;
    }
}