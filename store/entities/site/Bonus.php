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
class Bonus extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public static function create($name, $summary, $body, $slug, $title, $description, $keywords): self
    {
        $bonus = new static();
        $bonus->name = $name;
        $bonus->summary = $summary;
        $bonus->body = $body;
        $bonus->slug = $slug;
        $bonus->title = $title;
        $bonus->description = $description;
        $bonus->keywords = $keywords;
        $bonus->status = self::STATUS_DRAFT;
        $bonus->created_at = time();

        return $bonus;
    }

    public function edit($name, $summary, $body, $slug, $title, $description, $keyword): void
    {
        $this->name = $name;
        $this->summary = $summary;
        $this->body = $body;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keyword;
        $this->updated_at = time();
    }

    public function getTitle(): string
    {
        return $this->title ?: $this->name;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function draft(): void
    {
        if ($this->isDraft()){
            throw new \DomainException('Бонус уже отключен.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function activate(): void
    {
        if ($this->isActive()){
            throw new \DomainException('Бонус уже активирован.');
        }
        $this->status = self::STATUS_ACTIVE;
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
            'status' => 'Состояние',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено'
        ];
    }

    public static function tableName(): string
    {
        return '{{%site_bonus}}';
    }
}