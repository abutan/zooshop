<?php

namespace store\useCases\manage\user;


use store\entities\user\User;
use store\forms\manage\user\UserCreateForm;
use store\forms\manage\user\UserEditForm;
use store\repositories\UserRepository;
use store\services\newsletter\Newsletter;
use store\services\RoleManager;
use store\services\TransactionsManager;

class UserManageService
{
    private $users;
    private $roles;
    private $transactions;
    private $newsLetter;

    public function __construct(UserRepository $users, RoleManager $roles, TransactionsManager $transactions, Newsletter $newsletter)
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->transactions = $transactions;
        $this->newsLetter = $newsletter;
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
            $this->newsLetter->subscribe($user->email);
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
            $form->password,
            $form->phone
        );
        $this->transactions->wrap(function () use ($user, $form){
            $this->users->save($user);
            $this->roles->assign($user->id, $form->role);
        });
    }

    public function subscribe($id): void
    {
        $user = $this->users->get($id);
        $user->subscribe();
        $this->newsLetter->subscribe($user->email);
        $this->users->save($user);
    }

    public function unSubscribe($id): void
    {
        $user = $this->users->get($id);
        $user->unSubscribe();
        $this->newsLetter->unsubscribe($user->email);
        $this->users->save($user);
    }

    public function remove($id): void
    {
        $user = $this->users->get($id);
        $this->newsLetter->unsubscribe($user->email);
        $this->users->remove($user);
    }
}