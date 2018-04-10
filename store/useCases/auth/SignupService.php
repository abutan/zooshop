<?php

namespace store\useCases\auth;


use store\access\Rbac;
use store\entities\user\User;
use store\forms\auth\SignupForm;
use store\repositories\UserRepository;
use store\services\newsletter\Newsletter;
use store\services\RoleManager;
use store\services\TransactionsManager;
use yii\mail\MailerInterface;

class SignupService
{
    private $users;
    private $transactions;
    private $mailer;
    private $roles;
    private $newsletter;

    public function __construct(UserRepository $users, TransactionsManager $transactions, MailerInterface $mailer, RoleManager $roles, Newsletter $newsletter)
    {
        $this->users = $users;
        $this->transactions = $transactions;
        $this->mailer = $mailer;
        $this->roles = $roles;
        $this->newsletter = $newsletter;
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
            ['html' => 'auth/signup/emailConfirmToken-html', 'text' => 'auth/signup/emailConfirmToken-text'],
            ['user' => $user]
        )
            ->setTo($form->email)
            ->setSubject('Подтверждение Email для "Дежурная ветаптека"')
            ->send();
        if (!$sent){
            throw new \RuntimeException('Ошибка отправки');
        }
    }

    public function confirm($token): void
    {
        if (empty($token)){
            throw new \DomainException('Отсутствует токен подтверждения.');
        }
        $user = $this->users->getByEmailConfirmToken($token);
        $user->confirmSignup();
        $this->newsletter->subscribe($user->email);
        $this->users->save($user);
    }
}