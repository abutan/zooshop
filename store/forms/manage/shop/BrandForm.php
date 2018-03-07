<?php

namespace store\forms\manage\shop;


use store\entities\shop\Brand;
use store\validators\SlugValidator;
use yii\base\Model;

class BrandForm extends Model
{
    public $name;
    public $slug;
    public $title;
    public $description;
    public $keywords;

    private $_brand;

    public function __construct(Brand $brand = NULL, array $config = []) {
        if ($brand) {
            $this->name = $brand->name;
            $this->slug = $brand->slug;
            $this->title = $brand->title;
            $this->description = $brand->description;
            $this->keywords = $brand->keywords;
            $this->_brand = $brand;
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            ['name', 'required'],
            [['name', 'slug', 'title', 'description', 'keywords'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : NULL],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Название',
            'slug' => 'Алиас',
            'title' => 'МЕТА заголовок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
        ];
    }
}