<?php

namespace store\forms\manage\site;


use store\entities\site\Article;
use store\validators\SlugValidator;
use yii\base\Model;

class ArticleManageForm extends Model
{
    public $name;
    public $summary;
    public $body;
    public $slug;
    public $title;
    public $description;
    public $keywords;

    private $_article;

    public function __construct(Article $article = null, array $config = [])
    {
        if ($article){
            $this->name = $article->name;
            $this->summary = $article->summary;
            $this->body = $article->body;
            $this->slug = $article->slug;
            $this->title = $article->title;
            $this->description = $article->description;
            $this->keywords = $article->keywords;
            $this->_article = $article;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            [['name', 'slug', 'title', 'description', 'keywords'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            ['slug', 'unique', 'targetClass' => Article::class, 'message' => 'Данный алиас уже задействован. Введите другой, или модифицируйте действующий.', 'filter' => $this->_article ? ['<>', 'id', $this->_article->id] : null],
            [['summary', 'body'], 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Заголовок',
            'summary' => 'Анонс статьи',
            'body' => 'Текст статьи',
            'slug' => 'Алиас',
            'title' => 'МЕТА заголовок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
        ];
    }
}