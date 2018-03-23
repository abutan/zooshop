<?php

namespace store\cart\cost\calculator;


use store\cart\CartItem;
use store\cart\cost\Cost;

interface CalculatorInterface
{
    /**
     * @param CartItem[] $items
     * @return Cost
     */
    public function getCost(array $items): Cost;
}