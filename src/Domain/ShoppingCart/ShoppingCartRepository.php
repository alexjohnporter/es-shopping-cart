<?php

namespace App\Domain\ShoppingCart;

interface ShoppingCartRepository
{
    public function save(ShoppingCart $cart): void;

    public function get(string $cartId): ShoppingCart;
}