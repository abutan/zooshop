<?php

namespace frontend\widgets\site;


use Yii;
use store\entities\site\Comment;
use store\forms\site\CommentForm;
use yii\jui\Widget;

class CommentWidget extends Widget
{
    public function run()
    {
        $form = new CommentForm();

        $comments = Comment::find()->orderBy(['parent_id' => SORT_ASC, 'id' => SORT_ASC])->all();
        $items = $this->treeRecursive($comments, null);

        return $this->render('comments/comments', [
            'model' => $form,
            'items' => $items,
        ]);
    }

    public function treeRecursive(&$comments, $parentId): array
    {
        $items = [];
        foreach ($comments as $comment){
            if ($comment->parent_id == $parentId){
                $items[] = new CommentView($comment, $this->treeRecursive($comments, $comment->id));
            }
        }
        return $items;
    }
}