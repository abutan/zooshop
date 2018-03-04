<?php

namespace store\services\auth;


use store\entities\user\User;
use store\forms\auth\LoginForm;
use store\repositories\UserRepository;

class AuthService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->users->getByUserName($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)){
            throw new \DomainException('Неправильный логин или пароль.');
        }
        return $user;
    }
}