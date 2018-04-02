<?php

namespace store\forms\site;


use store\entities\site\Comment;
use yii\base\Model;

class CommentEditForm extends Model
{
    public $parentId;
    public $text;

    public function __construct(Comment $comment, array $config = []) {
        parent::__construct($config);
        $this->parentId = $comment->parent_id;
        $this->text = $comment->text;
    }

    public function rules() {
        return [
            ['text', 'required'],
            ['text', 'string'],
            ['parentId', 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'text' => 'Предложение ',
            'parentId' => 'ID родительского сообщения',
        ];
    }
}