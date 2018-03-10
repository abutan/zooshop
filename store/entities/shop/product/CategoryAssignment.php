<?php

namespace store\entities\shop\product;


use yii\db\ActiveRecord;

/**
 * @property int $product_id [int(11)]
 * @property int $category_id [int(11)]
 */
class CategoryAssignment extends ActiveRecord
{
    public static function create($categoryId): self
    {
        $assignment = new static();
        $assignment->category_id = $categoryId;

        return $assignment;
    }

    public function isForCategory($id): bool
    {
        return $this->category_id == $id;
    }

    public static function tableName()
    {
        return '{{%category_assignments}}';
    }
}