<?php

namespace store\entities\site;


use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $summary
 * @property string $body
 * @property string $slug [varchar(255)]
 * @property string $title [varchar(255)]
 * @property string $description [varchar(255)]
 * @property string $keywords [varchar(255)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 */
class Notification extends ActiveRecord
{
    public static function create($name, $summary, $body, $slug, $title, $description, $keywords): self
    {
        $notification = new static();
        $notification->name = $name;
        $notification->summary = $summary;
        $notification->body = $body;
        $notification->slug = $slug;
        $notification->title = $title;
        $notification->description = $description;
        $notification->keywords = $keywords;
        $notification->created_at = time();

        return $notification;
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

    public function getTitle(): string
    {
        return $this->title ?: $this->name;
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Заголовок',
            'summary' => 'Анонс',
            'body' => 'Полный текст',
            'slug' => 'Алиас',
            'title' => 'МЕТА заголовок',
            'description' => 'МЕТА описание',
            'keywords' => 'МЕТА ключевые слова',
            'updated_at' => 'Обновлено',
            'created_at' => 'Создано' ,
        ];
    }

    public static function tableName(): string
    {
        return '{{%site_notifications}}';
    }
}