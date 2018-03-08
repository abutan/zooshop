<?php

namespace store\forms\manage\shop;


use store\entities\shop\Tag;
use store\validators\SlugValidator;
use yii\base\Model;

class TagForm extends Model
{
    public $name;
    public $slug;

    private $_tag;

    public function __construct(Tag $tag = NULL, array $config = []) {
        if ($tag){
            $this->name = $tag->name;
            $this->slug = $tag->slug;
            $this->_tag = $tag;
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            ['name', 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Tag::class, 'filter' => $this->_tag ? ['<>', 'id', $this->_tag->id] : NULL],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Метка(тэг)',
            'slug' => 'Алиас',
        ];
    }
}