<?php

namespace store\services\auth;


use store\entities\user\User;
use store\repositories\UserRepository;

class NetworkService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth($identity, $network): User
    {
        if ($user = $this->users->findByNetworkIdentity($identity, $network)){
            return $user;
        }

        $user = User::signupByNetwork($identity, $network);
        $this->users->save($user);

        return $user;
    }

    public function attach($id, $identity, $network): void
    {
        if ($this->users->findByNetworkIdentity($identity, $network)){
            throw new \DomainException('Соц. сеть уже привязана.');
        }
        $user = $this->users->get($id);
        $user->attachNetwork($identity, $network);
        $this->users->save($user);
    }
}