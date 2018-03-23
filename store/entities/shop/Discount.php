<?php

namespace store\entities\shop;


use store\entities\shop\queries\DiscountQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property int $percent [int(11)]
 * @property string $name [varchar(255)]
 * @property string $from_date [date]
 * @property string $to_date [date]
 * @property bool $active [tinyint(1)]
 * @property int $sort [int(11)]
 */
class Discount extends ActiveRecord
{
    public static function create($percent, $name, $fromDate, $toDate, $sort): self
    {
        $discount = new static();
        $discount->percent = $percent;
        $discount->name = $name;
        $discount->from_date = $fromDate;
        $discount->to_date = $toDate;
        $discount->sort = $sort;
        $discount->active = true;

        return $discount;
    }

    public function edit($percent, $name, $fromDate, $toDate, $sort): void
    {
        $this->percent = $percent;
        $this->name = $name;
        $this->from_date = $fromDate;
        $this->to_date = $toDate;
        $this->sort = $sort;
    }

    public function activate(): void
    {
        $this->active = true;
    }

    public function draft(): void
    {
        $this->active = false;
    }

    public function isEnable(): bool
    {
        return true;
    }

    public static function tableName()
    {
        return '{{%shop_discounts}}';
    }

    public static function find()
    {
        return new DiscountQuery(static::class);
    }

    public function attributeLabels(): array
    {
        return [
            'percent' => 'Размер скидки %',
            'name' => 'Название',
            'fromDate' => 'Дата начала',
            'from_date' => 'Дата начала',
            'toDate' => 'Дата окончания',
            'to_date' => 'Дата окончания',
            'active' => 'Состояние',
        ];
    }
}