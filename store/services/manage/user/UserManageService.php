<?php

namespace store\services\manage\user;


use store\entities\user\User;
use store\forms\manage\user\UserCreateForm;
use store\forms\manage\user\UserEditForm;
use store\repositories\UserRepository;

class UserManageService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->phone,
            $form->password
        );
        $this->users->save($user);

        return $user;
    }

    public function edit($id, UserEditForm $form): void
    {
        $user = $this->users->get($id);
        $user->edit(
            $form->username,
            $form->email,
            $form->phone,
            $form->password
        );
        $this->users->save($user);
    }

    public function remove($id): void
    {
        $user = $this->users->get($id);
        $this->users->save($user);
    }
}