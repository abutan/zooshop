<?php

namespace store\forms\manage\shop\product;


use store\entities\shop\product\Review;
use yii\base\Model;

class ReviewEditForm extends Model
{
    public $vote;
    public $text;

    public function __construct(Review $review, array $config = [])
    {
        $this->vote = $review->vote;
        $this->text = $review->text;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['vote', 'text'], 'required'],
            ['vote', 'in', 'range' => [1, 2, 3, 4, 5]],
            ['text', 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'vote' => 'Оценка',
            'text' => 'Отзыв',
        ];
    }
}