<?php

namespace frontend\widgets\site;


use store\entities\site\Comment;

class CommentView
{
    public $comment;
    /* @var self */
    public $children;

    public function __construct(Comment $comment, array $children)
    {
        $this->comment = $comment;
        $this->children = $children;
    }
}