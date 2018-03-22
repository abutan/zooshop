<?php

namespace store\entities\shop;


use paulzi\nestedsets\NestedSetsBehavior;
use store\entities\shop\queries\CategoryQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property int $parent_id [int(11)]
 * @property string $body
 * @property string $slug [varchar(255)]
 * @property string $title [varchar(255)]
 * @property string $description [varchar(255)]
 * @property string $keywords [varchar(255)]
 * @property int $lft [int(11)]
 * @property int $rgt [int(11)]
 * @property int $depth [int(11)]
 *
 * @mixin NestedSetsBehavior
 * @property Category $prev
 * @property Category $next
 * @property Category[] $parents
 */
class Category extends ActiveRecord
{
    public static function create($name, $parentId, $body, $slug, $title, $description, $keywords): self
    {
        $category = new static();
        $category->name = $name;
        $category->parent_id = $parentId;
        $category->body = $body;
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        $category->keywords = $keywords;

        return $category;
    }

    public function edit($name, $parentId, $body, $slug, $title, $description, $keywords)
    {
        $this->name = $name;
        $this->parent_id = $parentId;
        $this->body = $body;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }

    public function behaviors() {
        return [
            NestedSetsBehavior::class,
        ];
    }

    public function transactions() {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find() {
        return new CategoryQuery(static::class);
    }

    public function attributeLabels() {
        return [
            'name' => 'Название',
            'parent_id' => 'Родительская категория',
            'parentId' => 'Родительская категория',
            'body' => 'Описание',
            'slug' => 'Алиас',
            'title' => 'МЕТА заголовок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
        ];
    }

    public static function tableName() {
        return '{{%shop_categories}}';
    }
}