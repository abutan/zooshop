<?php

namespace store\repositories;


use store\entities\user\User;
use yii\web\NotFoundHttpException;

class UserRepository
{
    public function get($id): User
    {
        return User::findOne($id);
    }

    public function getByUserName($username): User
    {
        if (!$user = User::findOne(['username' => $username])){
            throw new NotFoundHttpException('Пользователь не найден.');
        }
        return $user;
    }

    public function getByEmailConfirmToken($token): User
    {
        if (!$user = User::findOne(['email_confirm_token' => $token])){
            throw new NotFoundHttpException('Пользователь не найден.');
        }
        return $user;
    }

    public function getByEmail($email): User
    {
        if (!$user = User::findOne(['email' => $email])){
            throw new NotFoundHttpException('Пользователь не найден.');
        }
        return $user;
    }

    public function getByPasswordResetToken($token): User
    {
        if (!$user = User::findOne(['password_reset_token' => $token])){
            throw new NotFoundHttpException('Пользователь не найден.');
        }
        return $user;
    }

    public function existsByPasswordResetToken($token): bool
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    public function save(User $user): void
    {
        if (!$user->save()){
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(User $user): void
    {
        if (!$user->delete()){
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}