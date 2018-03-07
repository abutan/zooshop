<?php

namespace store\forms\manage\shop;


use store\entities\shop\Maker;
use store\validators\SlugValidator;
use yii\base\Model;

class MakerManageForm extends Model
{
    public $name;
    public $body;
    public $slug;
    public $title;
    public $description;
    public $keywords;

    private $_maker;

    public function __construct(Maker $maker = NULL, array $config = []) {
        if ($maker){
            $this->name = $maker->name;
            $this->body = $maker->body;
            $this->slug = $maker->slug;
            $this->title = $maker->title;
            $this->description = $maker->description;
            $this->keywords = $maker->keywords;
            $this->_maker = $maker;
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            ['name', 'required'],
            [['name', 'slug', 'title', 'description', 'keywords'], 'string', 'max' => 255],
            ['body', 'string'],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Maker::class, 'filter' => $this->_maker ? ['<>', 'id', $this->_maker->id] : NULL],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Название',
            'slug' => 'Алиас',
            'body' => 'Описание',
            'title' => 'МЕТА заголовок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
        ];
    }
}