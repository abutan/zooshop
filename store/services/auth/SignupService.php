<?php

namespace store\services\auth;


use store\entities\user\User;
use store\forms\auth\SignupForm;
use store\repositories\UserRepository;
use store\services\TransactionsManager;
use yii\mail\MailerInterface;

class SignupService
{
    private $users;
    private $transactions;
    private $mailer;

    public function __construct(UserRepository $users, TransactionsManager $transactions, MailerInterface $mailer)
    {
        $this->users = $users;
        $this->transactions = $transactions;
        $this->mailer = $mailer;
    }

    public function signup(SignupForm $form): void
    {
        $user = User::signupRequest(
            $form->username,
            $form->email,
            $form->phone,
            $form->password
        );
        $this->users->save($user);

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