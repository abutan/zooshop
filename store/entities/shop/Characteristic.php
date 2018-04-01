<?php

namespace store\entities\shop;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property int $category_id [int(11)]
 * @property int $sort [int(11)]
 *
 * @property Category $category
 */
class Characteristic extends ActiveRecord
{
    public static function create($name, $categoryId, $sort): self
    {
        $item = new static();
        $item->name = $name;
        $item->category_id = $categoryId;
        $item->sort = $sort;

        return $item;
    }

    public function edit($name, $categoryId, $sort): void
    {
        $this->name = $name;
        $this->category_id = $categoryId;
        $this->sort = $sort;
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название атрибута',
            'category_id' => 'Категория',
            'categoryId' => 'Категория',
        ];
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public static function tableName()
    {
        return '{{%characteristics}}';
    }
}