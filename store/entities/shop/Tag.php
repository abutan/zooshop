<?php

namespace store\entities\shop;


use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $slug [varchar(255)]
 */
class Tag extends ActiveRecord
{
    public static function create($name, $slug): self
    {
        $tag = new static();
        $tag->name = $name;
        $tag->slug = $slug;

        return $tag;
    }

    public function edit($name, $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public function attributeLabels() {
        return [
            'name' => 'Метка(тэг)',
            'slug' => 'Алиас',
        ];
    }

    public static function tableName() {
        return 'product_tags';
    }
}