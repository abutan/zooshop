<?php

namespace store\entities\site;


use store\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property int $user_id [int(11)]
 * @property string $text
 * @property int $parent_id [int(11)]
 * @property int $created_at [int(11) unsigned]
 * @property bool $status [tinyint(1)]
 *
 * @property User $user
 */
class Comment extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public static function create($userId, $parentId, $text): self
    {
        $comment = new static();
        $comment->user_id = $userId;
        $comment->parent_id = $parentId;
        $comment->text = $text;
        $comment->created_at = time();
        $comment->status = self::STATUS_ACTIVE;

        return $comment;
    }

    public function edit($parentId, $text): void
    {
        $this->parent_id = $parentId;
        $this->text = $text;
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
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        $this->status = self::STATUS_DRAFT;
    }

    public function isEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public function isChildOf($id): bool
    {
        return $this->parent_id == $id;
    }

    public function attributeLabels(): array
    {
        return [
            'text' => 'Предложения',
            'user_id' => 'Пользователь',
            'created_at' => 'Отправлено',
            'status' => 'Состояние',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function tableName()
    {
        return '{{%site_comments}}';
    }
}