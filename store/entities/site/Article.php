<?php

namespace store\entities\site;


use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $summary
 * @property string $body
 * @property string $slug [varchar(255)]
 * @property int $status [smallint(6)]
 * @property string $title [varchar(255)]
 * @property string $description [varchar(255)]
 * @property string $keywords [varchar(255)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 */
class Article extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public static function create($name, $summary, $body, $slug, $title, $description, $keywords): Article
    {
        $article = new static();
        $article->name = $name;
        $article->summary = $summary;
        $article->body = $body;
        $article->slug = $slug;
        $article->title = $title;
        $article->description = $description;
        $article->keywords = $keywords;
        $article->status = self::STATUS_DRAFT;
        $article->created_at = time();

        return $article;
    }

    public function edit($name, $summary, $body, $slug, $title, $description, $keywords): void
    {
        $this->name = $name;
        $this->summary = $summary;
        $this->body = $body;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->updated_at = time();
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function activate(): void
    {
        if ($this->isActive()){
            throw new \DomainException('Статья уже опубликована.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        if ($this->isDraft()){
            throw new \DomainException('Статья уже отключена.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Заголовок',
            'summary' => 'Анонс статьи',
            'body' => 'Текст статьи',
            'slug' => 'Алиас',
            'status' => 'Состояние',
            'updated_at' => 'Обновлено',
            'created_at' => 'Создано',
            'title' => 'МЕТА заголовок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
        ];
    }

    public static function tableName()
    {
        return '{{%site_articles}}';
    }
}