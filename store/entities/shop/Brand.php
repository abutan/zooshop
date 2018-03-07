<?php

namespace store\entities\shop;


use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $slug [varchar(255)]
 * @property string $title [varchar(255)]
 * @property string $description [varchar(255)]
 * @property string $keywords [varchar(255)]
 */
class Brand extends ActiveRecord
{
    public static function create($name, $slug, $title, $description, $keywords): self
    {
        $brand = new static();
        $brand->name = $name;
        $brand->slug = $slug;
        $brand->title = $title;
        $brand->description = $description;
        $brand->keywords = $keywords;

        return $brand;
    }

    public function edit($name, $slug, $title, $description, $keywords): void
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }

    public function getTitle(): string
    {
        return $this->title ?: $this->name;
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название',
            'slug' => 'Алиас',
            'title' => 'МЕТА заголовок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
        ];
    }

    public static function tableName() {
        return '{{%product_brands}}';
    }
}