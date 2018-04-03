<?php

namespace store\forms\site;


use store\entities\site\Bonus;
use store\validators\SlugValidator;
use yii\base\Model;

class BonusForm extends Model
{
    public $name;
    public $summary;
    public $body;
    public $slug;
    public $title;
    public $description;
    public $keywords;

    private $_bonus;

    public function __construct(Bonus $bonus = null, array $config = [])
    {
        if ($bonus){
            $this->name = $bonus->name;
            $this->summary = $bonus->summary;
            $this->body = $bonus->body;
            $this->slug = $bonus->slug;
            $this->title = $bonus->title;
            $this->description = $bonus->description;
            $this->keywords = $bonus->keywords;
            $this->_bonus = $bonus;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            [['name', 'slug', 'title', 'description', 'keywords'], 'string', 'max' => 255],
            [['summary', 'body'], 'string'],
            ['slug', SlugValidator::class],
            ['slug', 'unique', 'targetClass' => Bonus::class, 'message' => 'Такое значение уже используется.', 'filter' => $this->_bonus ? ['<>', 'id', $this->_bonus->id] : null],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название',
            'summary' => 'Анонс',
            'body' => 'Полный текст',
            'slug' => 'Алиас',
            'title' => 'МЕТА заголовок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
        ];
    }
}