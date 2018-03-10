<?php

namespace store\entities\shop\product;


use yii\db\ActiveRecord;

/**
 * @property int $product_id [int(11)]
 * @property int $tag_id [int(11)]
 */
class TagAssignment extends ActiveRecord
{
    public static function create($tagId): self
    {
        $assignment = new static();
        $assignment->tag_id = $tagId;

        return $assignment;
    }

    public function isForTag($id): bool
    {
        return $this->tag_id == $id;
    }

    public static function tableName()
    {
        return '{{%tag_assignments}}';
    }
}