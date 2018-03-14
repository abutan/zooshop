<?php

namespace store\entities\site;


use yii\db\ActiveRecord;

/**
 * @property int $slider_id [int(11)]
 * @property int $category_id [int(11)]
 */
class SliderAssignments extends ActiveRecord
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
        return '{{%slider_category_assignments}}';
    }
}