<?php

namespace store\forms\manage\shop;


use store\entities\shop\Category;
use store\validators\SlugValidator;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoryForm extends Model
{
    public $name;
    public $parentId;
    public $body;
    public $slug;
    public $title;
    public $description;
    public $keywords;

    private $_category;

    public function __construct(Category $category = NULL, array $config = []) {
        if ($category){
            $this->name = $category->name;
            $this->parentId = $category->parent_id;
            $this->body = $category->body;
            $this->slug = $category->slug;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->keywords = $category->keywords;
            $this->_category = $category;
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            ['name', 'required'],
            [['name', 'slug', 'title', 'description', 'keywords'], 'string', 'max' => 255],
            ['body', 'string'],
            ['parentId', 'integer'],
            ['slug', SlugValidator::class],
            [['slug'], 'unique', 'targetClass' => Category::class, 'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : NULL],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Название',
            'parentId' => 'Родительская категория',
            'body' => 'Описание',
            'slug' => 'Алиас',
            'title' => 'МЕТА заголовок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
        ];
    }

    public function parentCategoryList()
    {
        return ArrayHelper::map(Category::find()->orderBy('lft')->asArray()->all(), 'id', function (array  $category){
            return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth']-1).' ' : '').$category['name'];
        });
    }
}