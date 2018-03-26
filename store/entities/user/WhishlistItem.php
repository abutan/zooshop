<?php

namespace store\entities\user;


use yii\db\ActiveRecord;

/**
 * @property int $user_id [int(11)]
 * @property int $product_id [int(11)]
 */
class WhishlistItem extends ActiveRecord
{
    public static function create($productId): self
    {
        $item = new static();
        $item->product_id = $productId;

        return $item;
    }

    public function isForProduct($productId): bool
    {
        return $this->product_id == $productId;
    }

    public static function tableName(): string
    {
        return '{{%user_wishlist_items}}';
    }
}