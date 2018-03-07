<?php

namespace store\entities\shop;


use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $slug [varchar(255)]
 * @property string $body
 * @property string $title [varchar(255)]
 * @property string $description [varchar(255)]
 * @property string $keywords [varchar(255)]
 */
class Maker extends ActiveRecord
{
    public static function create($name, $slug, $body, $title, $description, $keywords): self
    {
        $maker = new static();
        $maker->name = $name;
        $maker->slug = $slug;
        $maker->body = $body;
        $maker->title = $title;
        $maker->description = $description;
        $maker->keywords = $keywords;

        return $maker;
    }

    public function edit($name, $slug, $body, $title, $description, $keywords): void
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->body = $body;
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название',
            'slug' => 'Алиас',
            'body' => 'Описание',
            'title' => 'МЕТА заголовок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: $this->name;
    }

    public static function tableName() {
        return '{{%product_makers}}';
    }
}