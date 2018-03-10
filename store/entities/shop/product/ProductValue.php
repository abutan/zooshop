<?php

namespace store\entities\shop\product;


use store\entities\shop\Characteristic;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $product_id [int(11)]
 * @property int $characteristic_id [int(11)]
 * @property string $value [varchar(255)]
 *
 * @property Characteristic $characteristic
 */
class ProductValue extends ActiveRecord
{
    public static function create($characteristicId, $text): self
    {
        $item = new static();
        $item->characteristic_id = $characteristicId;
        $item->value = $text;

        return $item;
    }

    public static function blank($characteristicId): self
    {
        $item = new static();
        $item->characteristic_id = $characteristicId;

        return $item;
    }

    public function changeValue($value): void
    {
        $this->value = $value;
    }

    public function isFoeCharacteristic($id): bool
    {
        return $this->characteristic_id == $id;
    }

    public function attributeLabels(): array
    {
        return [
            'value' => 'Значение',
            'text' => 'Значение',
        ];
    }

    public static function tableName()
    {
        return '{{%product_values}}';
    }

    public function getCharacteristic(): ActiveQuery
    {
        return $this->hasOne(Characteristic::class, ['id' => 'characteristic_id']);
    }
}