<?php

namespace store\services\manage\user;


use store\entities\user\User;
use store\forms\manage\user\UserCreateForm;
use store\forms\manage\user\UserEditForm;
use store\repositories\UserRepository;
use store\services\shop\RoleManager;
use store\services\TransactionsManager;

class UserManageService
{
    private $users;
    private $roles;
    private $transactions;

    public function __construct(UserRepository $users, RoleManager $roles, TransactionsManager $transactions)
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->transactions = $transactions;
    }

    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->phone,
            $form->password
        );

        $this->transactions->wrap(function () use ($user, $form){
            $this->users->save($user);
            $this->roles->assign($user->id, $form->role);
        });

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
        $this->transactions->wrap(function () use ($user, $form){
            $this->users->save($user);
            $this->roles->assign($user->id, $form->role);
        });
    }

    public function remove($id): void
    {
        $user = $this->users->get($id);
        $this->users->save($user);
    }
}