<?php

namespace store\services\site;


use store\entities\site\Comment;
use store\forms\site\CommentEditForm;
use store\forms\site\CommentForm;
use store\repositories\site\CommentRepository;
use store\repositories\UserRepository;

class CommentService
{
    private $comments;
    private $users;

    public function __construct(CommentRepository $comments, UserRepository $users)
    {
        $this->comments = $comments;
        $this->users = $users;
    }

    public function create($userId, CommentForm $form): Comment
    {
        $parent = $form->parentId ? $this->comments->get($form->parentId) : null;

        if ($parent && !$parent->isActive()){
            throw new \DomainException('Нельзя ответить на отключенный комментарий.');
        }

        $user = $this->users->get($userId);
        $comment = Comment::create(
            $user->id,
            $form->parentId,
            $form->text
        );
        $this->comments->save($comment);

        return $comment;
    }

    public function edit($id, CommentEditForm $form): void
    {
        $patent = $form->parentId ? $this->comments->get($form->parentId) : null;
        $comment = $this->comments->get($id);
        $comment->edit(
            $patent ? $patent->id : null,
            $form->text
        );
        $this->comments->save($comment);
    }

    public function activate($id): void
    {
        $comment = $this->comments->get($id);
        $comment->activate();
        $this->comments->save($comment);
    }

    public function draft($id): void
    {
        $comment = $this->comments->get($id);
        $comment->draft();
        $this->comments->save($comment);
    }

    public function remove($id): void
    {
        $comment = $this->comments->get($id);
        $this->comments->remove($comment);
    }
}