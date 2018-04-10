<?php

namespace store\useCases\auth;


use store\forms\auth\PasswordResetRequestForm;
use store\forms\auth\ResetPasswordForm;
use store\repositories\UserRepository;
use yii\mail\MailerInterface;

class PasswordResetService
{
    private $mailer;
    private $users;

    public function __construct(MailerInterface $mailer, UserRepository $users)
    {
        $this->users = $users;
        $this->mailer = $mailer;
    }

    public function request(PasswordResetRequestForm $form): void
    {
        $user = $this->users->getByEmail($form->email);

        if (!$user->isActive()){
            throw new \DomainException('Регистрация пользователя не закончена.');
        }

        $user->requestPasswordReset();

        $this->users->save($user);

        $sent =  $this->mailer->compose(
            ['html' => 'auth/reset/passwordResetToken-html', 'text' => 'auth/reset/passwordResetToken-text'],
            ['user' => $user]
        )
            ->setTo($form->email)
            ->setSubject('Запрос на восстановление (изменение) пароля. Сайт "Дежурная ветаптека"')
            ->send();
        if (!$sent){
            throw new \DomainException('Ошибка отправки. Попробуйте повторить позже.');
        }
    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)){
            throw new \DomainException('Сделайте запрос на восстановление пароля.');
        }
        if (!$this->users->existsByPasswordResetToken($token)){
            throw new \DomainException('Ошибка при восстановлении (изменении) пароля.');
        }
    }

    public function reset($token, ResetPasswordForm $form): void
    {
        $user = $this->users->getByPasswordResetToken($token);
        $user->resetPassword($form->password);
        $this->users->save($user);
    }
}