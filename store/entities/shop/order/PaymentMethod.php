<?php

namespace store\entities\shop\order;


use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 */
class PaymentMethod extends ActiveRecord
{
    public static function create($name): self
    {
        $method = new static();
        $method->name = $name;

        return $method;
    }

    public function edit($name): void
    {
        $this->name = $name;
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Метод оплаты',
        ];
    }

    public static function tableName()
    {
        return '{{%shop_payment_methods}}';
    }
}