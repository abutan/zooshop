<?php

namespace store\entities\shop\product;


use store\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property int $user_id [int(11)]
 * @property int $product_id [int(11)]
 * @property int $vote [int(11)]
 * @property string $text
 * @property bool $active [tinyint(1)]
 * @property int $created_at [int(11)]
 * @property User $user
 */
class Review extends ActiveRecord
{
    public static function create($userId, int $vote, string $text): self
    {
        $review = new static();
        $review->user_id = $userId;
        $review->vote = $vote;
        $review->text = $text;
        $review->active = false;
        $review->created_at = time();

        return $review;
    }

    public function edit($vote, $text): void
    {
        $this->vote = $vote;
        $this->text = $text;
    }

    public function isActive(): bool
    {
        return $this->active == true;
    }

    public function isDraft(): bool
    {
        return $this->active == false;
    }

    public function activate(): void
    {
        if ($this->isActive()){
            throw new \DomainException('Отзыв уже опубликован.');
        }
        $this->active = true;
    }

    public function draft(): void
    {
        if ($this->isDraft()){
            throw new \DomainException('Отзыв уже отключен.');
        }
        $this->active = false;
    }

    public function getRating(): bool
    {
        return $this->vote;
    }

    public function isEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function tableName(): string
    {
        return '{{%product_reviews}}';
    }

    public function attributeLabels(): array
    {
        return [
            'user_id' => 'Пользователь',
            'vote' => 'Оценка',
            'text' => 'Отзыв',
            'active' => 'Состояние',
            'created_at' => 'Отправлен',
        ];
    }
}