<?php

namespace store\forms\shop;


use yii\base\Model;

class ReviewForm extends Model
{
    public $vote;
    public $text;

    public function rules(): array
    {
        return [
            [['vote', 'text'], 'required'],
            ['vote', 'in', 'range' => array_keys($this->voteList())],
            ['text', 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'vote' => 'Ваша оценка',
            'text' => 'Отзыв',
        ];
    }

    public function voteList(): array
    {
        return [
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
        ];
    }
}