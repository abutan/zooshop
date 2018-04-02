<?php

namespace store\repositories\site;


use store\entities\site\Comment;
use yii\web\NotFoundHttpException;

class CommentRepository
{
    public function get($id): Comment
    {
        if (!$comment = Comment::findOne($id)){
            throw new NotFoundHttpException('Такой комментарий не найден.');
        }
        return $comment;
    }

    public function save(Comment $comment)
    {
        if (!$comment->save()){
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Comment $comment)
    {
        if (!$comment->delete()){
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}