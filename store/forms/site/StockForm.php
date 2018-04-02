<?php

namespace store\forms\site;


use store\entities\site\Stock;
use store\validators\SlugValidator;
use yii\base\Model;

class StockForm extends Model
{
    public $name;
    public $dateFrom;
    public $dateTo;
    public $summary;
    public $body;
    public $slug;
    public $title;
    public $description;
    public $keywords;

    private $_stock;

    public function __construct(Stock $stock = null, array $config = [])
    {
        if ($stock){
            $this->name = $stock->name;
            $this->dateFrom = $stock->dateFrom;
            $this->dateTo = $stock->dateTo;
            $this->summary = $stock->summary;
            $this->body = $stock->body;
            $this->slug = $stock->slug;
            $this->title = $stock->title;
            $this->description = $stock->description;
            $this->keywords = $stock->keywords;
            $this->_stock = $stock;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            [['name', 'dateTo', 'dateFrom', 'title', 'description', 'keywords', 'slug'], 'string', 'max' => 255],
            [['summary', 'body'], 'string'],
            ['slug', SlugValidator::class],
            ['slug', 'unique', 'targetClass' => Stock::class, 'message' => 'Это значение уже используется.', 'filter' => $this->_stock ? ['<>', 'id', $this->_stock->id] : null],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название',
            'dateFrom' => 'Дата начала',
            'dateTo' => 'Дата окончания',
            'summary' => 'Анонс',
            'body' => 'Полный текст',
            'title' => 'МЕТА загловок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
            'slug' => 'Алиас',
        ];
    }
}