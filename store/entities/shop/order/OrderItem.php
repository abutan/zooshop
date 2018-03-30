<?php

namespace store\entities\shop\order;


use store\entities\shop\product\Product;
use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property int $order_id [int(11)]
 * @property int product_id
 * @property int $modification_id [int(11)]
 * @property string $product_name [varchar(255)]
 * @property string $product_code [varchar(255)]
 * @property string $modification_name [varchar(255)]
 * @property string $modification_code [varchar(255)]
 * @property int $price [int(11)]
 * @property int $quantity [int(11)]
 */
class OrderItem extends ActiveRecord
{
    public static function create(Product $product, $modificationId, $price, $quantity): self
    {
        $item = new static();
        $item->product_id = $product->id;
        $item->product_name = $product->name;
        $item->product_code = $product->code;
        if ($modificationId){
            $modification = $product->getModification($modificationId);
            $item->modification_id = $modification->id;
            $item->modification_name = $modification->name;
            $item->modification_code = $modification->code;
        }
        $item->price = $price;
        $item->quantity = $quantity;

        return $item;
    }

    public function getCost(): int
    {
        return $this->price * $this->quantity;
    }

    public function attributeLabels(): array
    {
        return [
            'order_id' => 'Номер заказа',
            'product_id' => 'ID товара',
            'modification_id' => 'ID модификации',
            'product_name' => 'Название товара',
            'product_code' => 'Артикул товара',
            'modification_name' => 'Название модификации товара',
            'modification_code' => 'Артикул модификации товара',
            'price' => 'Цена',
            'quantity' => 'Количество',
        ];
    }

    public static function tableName()
    {
        return '{{%shop_order_items}}';
    }
}