<?php

namespace store\services\site;


use store\entities\site\Comment;
use store\forms\site\CommentEditForm;
use store\forms\site\CommentForm;
use store\repositories\site\CommentRepository;
use store\repositories\UserRepository;
use yii\mail\MailerInterface;

class CommentService
{
    private $adminEmail;
    private $comments;
    private $users;
    private $mailer;

    public function __construct($adminEmail, MailerInterface $mailer, CommentRepository $comments, UserRepository $users)
    {
        $this->adminEmail = $adminEmail;
        $this->comments = $comments;
        $this->users = $users;
        $this->mailer = $mailer;
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

        $subject = 'На Вашем сайте пользователь написал новое предложение';
        if ($user->username):
            $body = '<p>Пользователь ' . $user->username . ' написал <br>';
        else:
            $body = '<p>Пользователь ' . $user->id . ' написал <br>';
        endif;
        $body .= \Yii::$app->formatter->asNtext($form->text).'<br>';
        $body .= 'Сайт &laquo;' . \Yii::$app->name .'&raquo; </p>';

        $sent = $this->mailer->compose()
            ->setSubject($subject)
            ->setTo($this->adminEmail)
            ->setHtmlBody($body)
            ->send();

        if (!$sent){
            throw new \DomainException('Ошибка отправки. Попробуйте повторить позже.');
        }

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