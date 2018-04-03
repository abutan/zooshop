<?php

namespace store\entities\site;


use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $dateFrom [varchar(255)]
 * @property string $dateTo [varchar(255)]
 * @property string $summary
 * @property string $body
 * @property string $slug [varchar(255)]
 * @property int $status [smallint(6)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 * @property string $title [varchar(255)]
 * @property string $description [varchar(255)]
 * @property string $keywords [varchar(255)]
 */
class Stock extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public static function create($name, $dateFrom, $dateTo, $summary, $body, $slug, $title, $description, $keywords): self
    {
        $stock = new static();
        $stock->name = $name;
        $stock->dateFrom = $dateFrom;
        $stock->dateTo = $dateTo;
        $stock->summary = $summary;
        $stock->body = $body;
        $stock->slug = $slug;
        $stock->title = $title;
        $stock->description = $description;
        $stock->keywords = $keywords;
        $stock->status = self::STATUS_DRAFT;
        $stock->created_at = time();

        return $stock;
    }

    public function edit($name, $dateFrom, $dateTo, $summary, $body, $slug, $title, $description, $keywords): void
    {
        $this->name = $name;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->summary = $summary;
        $this->body = $body;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->updated_at = time();
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function activate(): void
    {
        if ($this->isActive()){
            throw new \DomainException('Тема уже активирована.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        if ($this->isDraft()){
            throw new \DomainException('Тема уже отключена.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function getTitle(): string
    {
        return $this->title ?: $this->name;
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название',
            'dateFrom' => 'Дата начала',
            'dateTo' => 'Дата окончания',
            'summary' => 'Анонс',
            'body' => 'Полный текст',
            'slug' => 'Алиас',
            'title' => 'МЕТА загловок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
            'status' => 'Состояние',
            'created_at' => 'Создано',
            'updated_at' => 'Отредактировано',
        ];
    }

    public static function tableName(): string
    {
        return '{{%site_stocks}}';
    }
}