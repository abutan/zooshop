<?php

namespace store\cart\storage;


use store\cart\CartItem;

interface StorageInterface
{

    /**
     * @return CartItem[]
     */
    public function load(): array;

    /**
     * @param CartItem[] $items
     */
    public function save(array $items): void;
}