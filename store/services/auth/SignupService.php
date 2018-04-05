<?php

namespace store\services\auth;


use store\access\Rbac;
use store\entities\user\User;
use store\forms\auth\SignupForm;
use store\repositories\UserRepository;
use store\services\shop\RoleManager;
use store\services\TransactionsManager;
use yii\mail\MailerInterface;

class SignupService
{
    private $users;
    private $transactions;
    private $mailer;
    private $roles;

    public function __construct(UserRepository $users, TransactionsManager $transactions, MailerInterface $mailer, RoleManager $roles)
    {
        $this->users = $users;
        $this->transactions = $transactions;
        $this->mailer = $mailer;
        $this->roles = $roles;
    }

    public function signup(SignupForm $form): void
    {
        $user = User::signupRequest(
            $form->username,
            $form->email,
            $form->phone,
            $form->password
        );

        $this->transactions->wrap(function () use ($user){
            $this->users->save($user);
            $this->roles->assign($user->id, Rbac::ROLE_USER);
        });

        $sent = $this->mailer->compose(
            ['html' => 'emailConfirmToken-html', 'text' => 'emailConfirmToken-text'],
            ['user' => $user]
        )
            ->setTo($form->email)
            ->setSubject('Подтверждение Email для регистрации на сайте '. \Yii::$app->name)
            ->send();

        if (!$sent){
            throw new \DomainException('Ошибка отправки. Попробуй повторить позже.');
        }
    }

    public function confirm($token): void
    {
        if (empty($token)){
            throw new \DomainException('Отсутствует токен подтверждения.');
        }
        $user = $this->users->getByEmailConfirmToken($token);
        $user->confirmSignup();
        $this->users->save($user);
    }
}