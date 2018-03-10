<?php

namespace store\entities\shop\product;


use yii\db\ActiveRecord;

/**
 * @property int $product_id [int(11)]
 * @property int $related_id [int(11)]
 */
class RelatedAssignment extends ActiveRecord
{
    public static function create($productId): self
    {
        $assignment = new static();
        $assignment->related_id = $productId;

        return $assignment;
    }

    public function isForProduct($id): bool
    {
        return $this->related_id == $id;
    }

    public static function tableName()
    {
        return '{{%product_related_assignments}}';
    }
}