<?php

namespace store\services\cabinet;


use store\repositories\manage\shop\ProductRepository;
use store\repositories\UserRepository;

class WhishlistService
{
    private $users;
    private $products;

    public function __construct(UserRepository $users, ProductRepository $products)
    {
        $this->users = $users;
        $this->products = $products;
    }

    public function add($userId, $productId): void
    {
        $user = $this->users->get($userId);
        $product = $this->products->get($productId);
        $user->addToWhishlist($product->id);
        $this->users->save($user);
    }

    public function remove($userId, $productId): void
    {
        $user = $this->users->get($userId);
        $product = $this->products->get($productId);
        $user->removeFromWhishlist($product->id);
        $this->users->save($user);
    }
}