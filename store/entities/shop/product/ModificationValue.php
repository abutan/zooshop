<?php

namespace store\entities\shop\product;


use store\entities\shop\Characteristic;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 * @property int $modification_id [int(11)]
 * @property int $characteristic_id [int(11)]
 * @property string $value [varchar(255)]
 *
 * @property Characteristic $characteristic
 */

class ModificationValue extends ActiveRecord
{
    public static function create($characteristicId, $value): self
    {
        $item = new static();
        $item->characteristic_id = $characteristicId;
        $item->value = $value;

        return $item;
    }

    public static function blank($characteristicId): self
    {
        $item = new static();
        $item->characteristic_id = $characteristicId;

        return $item;
    }

    public function isForCharacteristic($characteristicId): bool
    {
        return $this->characteristic_id == $characteristicId;
    }

    public function change($value): void
    {
        $this->value = $value;
    }

    public function getCharacteristic(): ActiveQuery
    {
        return $this->hasOne(Characteristic::class, ['id' => 'characteristic_id']);
    }

    public static function tableName()
    {
        return '{{%modification_values}}';
    }
}