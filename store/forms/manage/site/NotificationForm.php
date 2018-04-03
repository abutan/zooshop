<?php

namespace store\forms\manage\site;


use store\entities\site\Notification;
use store\validators\SlugValidator;
use yii\base\Model;

class NotificationForm extends Model
{
    public $name;
    public $summary;
    public $body;
    public $slug;
    public $title;
    public $description;
    public $keywords;

    private $_notification;

    public function __construct(Notification $notification = null, array $config = [])
    {
        if ($notification){
            $this->name = $notification->name;
            $this->summary = $notification->summary;
            $this->body = $notification->body;
            $this->slug = $notification->slug;
            $this->title = $notification->title;
            $this->description = $notification->description;
            $this->keywords = $notification->keywords;
            $this->_notification = $notification;
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
            ['slug', 'unique', 'targetClass' => Notification::class, 'message' => 'Это значение уже используется.', 'filter' => $this->_notification ? ['<>', 'id', $this->_notification->id] : null],
        ];
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
        ];
    }
}